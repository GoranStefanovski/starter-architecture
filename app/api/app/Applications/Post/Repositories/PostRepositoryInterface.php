<?php

namespace App\Applications\Post\Repositories;

use App\Applications\Pagination\StarterPaginator;
use App\Applications\Post\DTO\PostDTO;
use App\Applications\Post\Model\Post;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Interface PostRepositoryInterface
 * @package App\Applications\Post
 */
interface PostRepositoryInterface{
    /**
     * @return array
     */
    public function getAll(): array;

    /**
     * @param integer $id
     * @return Post
     */
    public function get($id): Post;

    /**
     * @param PostDTO $postDTO
     * @return Post
     */
    public function create(PostDTO $postDTO): Post;

    /**
     * @param int $postId
     * @param PostDTO $postDTO
     * @return Post
     */
    public function update(int $postId, PostDTO $postDTO): Post;

    /**
     * @param integer $id
     * @return boolean
     */
    public function delete(int $id);

    /**
     * @param array $data
     * @return StarterPaginator
     */
    public function draw(array $data): StarterPaginator;

    /**
     * Clear the post_image collection for a given post.
     *
     * @param integer $postId
     * @return void
     */
    public function clearPostImage(int $postId): void;

    /**
     * Upload a new post_image for a given Post.
     *
     * @param integer $postId
     * @param UploadedFile $file
     * @return Post
     */
    public function uploadPostImage(int $postId, UploadedFile $file): Post;
}
