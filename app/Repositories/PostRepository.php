<?php

namespace App\Repositories;

use App\Http\Requests\PostRequest;
use App\Interfaces\PostInterface;
use App\Traits\ResponseAPI;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostRepository implements PostInterface
{
  // Gunakan ResponseAPI Trait di repository
  use ResponseAPI;

  public function getAllPosts()
  {
    try {
      $post = Post::all();
      return $this->success("Semua Posts", $post);
    } catch (\Exception $e) {
      return $this->error($e->getMessage(), $e->getCode());
    }
  }

  public function getPostById($id)
  {
    try {
      $post = Post::find($id);

      //Cek apakah Post nya ada atau tidak
      if (!$post) return response()->json(['message' => "Tidak ada Post dengan ID $id"], 404);
      return $this->success("Detail Post", $post);
    } catch (\Exception $e) {
      return $this->error($e->getMessage(), $e->getCode());
    }
  }

  public function requestPost(PostRequest $request, $id = null)
  {
    DB::beginTransaction();
    try {
      // Jika Postnya sdh ada ketika dicari
      // Maka lakukan update Post
      // Jika belum ada Postnya, create Post baru
      $post = $id ? Post::find($id) : new Post;

      // Cek Postnya
      if ($id && !$post) return $this->error("Tidak ada Post dengan ID $id", 404);

      $post->post_author = $request->post_author;

      $post->post_title = $request->post_title;
      $post->post_content = $request->post_content;
      if (!$id) $post->post_date = $request->post_date;
      // Simpan Post
      $post->save();
      DB::commit();
      return $this->success(
        $id ? "Post berhasil diubah" :
          "Post berhasil dibuat",
        $post,
        $id ? 200 : 201
      );
    } catch (\Exception $e) {
      DB::rollBack();
      return $this->error($e->getMessage(), $e->getCode());
    }
  }

  public function deletePost($id)
  {
    DB::beginTransaction();
    try {
      $post = Post::find($id);

      // Cek Postnya
      if (!$post) return $this->error("Tidak ada Post dengan ID $id", 404);

      // Hapus Post
      $post->delete();

      DB::commit();
      return $this->success("Post berhasil dihapus", $post);
    } catch (\Exception $e) {
      DB::rollBack();
      return $this->error($e->getMessage(), $e->getCode());
    }
  }
}
