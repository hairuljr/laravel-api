<?php

namespace App\Repositories;

use App\Http\Requests\UserRequest;
use App\Interfaces\UserInterface;
use App\Traits\ResponseAPI;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserInterface
{
  // Gunakan ResponseAPI Trait di repository
  use ResponseAPI;

  public function getAllUsers()
  {
    try {
      $user = User::all();
      return $this->success("Semua Users", $user);
    } catch (\Exception $e) {
      return $this->error($e->getMessage(), $e->getCode());
    }
  }

  public function getUserById($id)
  {
    try {
      $user = User::find($id);

      //Cek apakah user nya ada atau tidak
      if (!$user) return response()->json(['message' => "Tidak ada user dengan ID $id"], 404);
      return $this->success("Detail User", $user);
    } catch (\Exception $e) {
      return $this->error($e->getMessage(), $e->getCode());
    }
  }

  public function requestUser(UserRequest $request, $id = null)
  {
    DB::beginTransaction();
    try {
      // Jika usernya sdh ada ketika dicari
      // Maka lakukan update User
      // Jika belum ada usernya, create user baru
      $user = $id ? User::find($id) : new User;

      // Cek Usernya
      if ($id && !$user) return $this->error("Tidak ada user dengan ID $id", 404);

      $user->name = $request->name;
      //hapus spasi dan jadikn ke lowercase
      $user->email = \preg_replace('/\s+/', '', \strtolower($request->email));

      //Disini kita tidak melakukan update password user
      if (!$id) $user->password = \Hash::make($request->password);

      // Simpan user
      $user->save();
      DB::commit();
      return $this->success(
        $id ? "User berhasil diubah" :
          "User berhasil dibuat",
        $user,
        $id ? 200 : 201
      );
    } catch (\Exception $e) {
      DB::rollBack();
      return $this->error($e->getMessage(), $e->getCode());
    }
  }

  public function deleteUser($id)
  {
    DB::beginTransaction();
    try {
      $user = User::find($id);

      // Cek usernya
      if (!$user) return $this->error("Tidak ada user dengan ID $id", 404);

      // Hapus user
      $user->delete();

      DB::commit();
      return $this->success("User berhasil dihapus", $user);
    } catch (\Exception $e) {
      DB::rollBack();
      return $this->error($e->getMessage(), $e->getCode());
    }
  }
}
