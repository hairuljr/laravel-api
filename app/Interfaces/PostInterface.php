<?php

namespace App\Interfaces;

use App\Http\Requests\PostRequest;

interface PostInterface
{
  /**
   * Get all Posts
   * 
   * @method  GET api/Posts
   * @access  public
   */
  public function getAllPosts();
  //===============================
  /**
   * Get Post By ID
   * 
   * @param   integer     $id
   * 
   * @method  GET api/Posts/{id}
   * @access  public
   */
  public function getPostById($id);
  //===============================
  /**
   * Create | Update Post
   * 
   * @param   \App\Http\Requests\PostRequest    $request
   * @param   integer                           $id
   * 
   * @method  POST    api/Posts       For Create
   * @method  PUT     api/Posts/{id}  For Update     
   * @access  public
   */
  public function requestPost(PostRequest $request, $id = null);
  //===============================
  /**
   * Delete Post
   * 
   * @param   integer     $id
   * 
   * @method  DELETE  api/Posts/{id}
   * @access  public
   */
  public function deletePost($id);
}
