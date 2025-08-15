<?php

namespace App\Applications\Post\Services;

use App\Applications\Post\DTO\PostDTO;
use Illuminate\Http\Request;

/**
 * Interface PostServiceInterface
 * @package App\Applications\Post
 */

interface PostServiceInterface
{
    /**
     * @return array
     */
    public function getAll(): array;

    /**
     * @param integer $id
     * @return PostDTO
     */
    public function get(int $id): PostDTO;

    /**
     * @param PostDTO $postDTO
     * @return PostDTO
     */
    public function create(PostDTO $postDTO): PostDTO;

    /**
     * @param int $postId
     * @param PostDTO $postDTO
     * @return PostDTO
     */
    public function update(int $postId, PostDTO $postDTO): PostDTO;

    /**
     * @param integer $id
     * @return boolean
     */
    public function delete(int $id);

    /**
     * @param array $data
     * @return array
     */
    public function draw(array $data): array;

    /**
     * Handle the avatar upload for a venue.
     *
     * @param int $postId
     * @param Request $request
     * @return PostDTO
     */
    public function uploadAvatar(int $postId, Request $request): PostDTO;
}
