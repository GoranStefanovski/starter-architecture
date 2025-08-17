<?php
namespace App\Applications\Post\Repositories;

use App\Applications\Post\DTO\PostDTO;
use App\Applications\Pagination\StarterPaginator;
use Illuminate\Http\UploadedFile;
use App\Applications\Post\Model\Post;

/**
 * @property Post $post
 */
class PostRepository implements PostRepositoryInterface{

    public function __construct(
        Post $post,
    ) {
        $this->post = $post;
    }

    private const COLUMNS_MAP = [
        'name' => 'posts.name',
        'description' => 'posts.description',
        'status' => 'posts.is_disabled',
        'boosted' => 'posts.is_boosted',
        'post_slot' => 'posts.post_slot'
    ];

    public function getAll(): array
    {
        // TODO: Implement getAll() method.
    }

    public function get($id): Post
    {
        return $this->post::with('media')->findOrFail($id);
    }

    public function create(PostDTO $postDTO): Post
    {
        $attributes = $postDTO->toArray();
        $post = new Post($attributes);
        $post->save();
        return $post;
    }

    public function update(int $postId, PostDTO $postDTO): Post
    {
        $post = $this->post->findOrFail($postId);
        $attributes = $postDTO->toArray();
        $post->update($attributes);

        return $post;
    }

    public function delete(int $id)
    {
        return $this->post::findOrFail($id)->delete();
    }

    public function draw(array $data): StarterPaginator
    {
        $query = $this->post
            ->select(['id', 'name', 'is_active', 'is_boosted', 'post_slot']);

        if (array_key_exists($data['column'], self::COLUMNS_MAP)) {
            $query->orderBy(self::COLUMNS_MAP[$data['column']], $data['dir']);
        }


        $search = $data['search'];
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->where('posts.name', 'like', '%' . $search . '%');
                $subquery->orWhere('posts.description', 'like', '%' . $search . '%');
                $subquery->orWhere('posts.post_slot', 'like', '%' . $search . '%');
            });
        }

        return $query->paginate($data['length']);
    }

    public function clearPostImage($postId): void
    {
        $this->get($postId)->clearMediaCollection('post_image');
    }

    public function uploadPostImage($postId, UploadedFile $file): Post
    {
        $post = $this->get($postId);
        $post->addMedia($file)->toMediaCollection('post_image');
        return $post;
    }
}
