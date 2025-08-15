<?php
namespace App\Applications\Post\Services;
use App\Applications\Post\DTO\PostDTO;
use App\Applications\Post\Model\Post;
use App\Applications\Post\Repositories\PostRepositoryInterface;
use App\Applications\Ticket\Model\Ticket;
use App\Applications\User\Model\User;
use Illuminate\Http\Request;

/**
 * @property PostRepositoryInterface $postRepository
 */
class PostService implements PostServiceInterface{

    public function __construct(
        PostRepositoryInterface $postRepository
    ) {
        $this->postRepository = $postRepository;
    }

    public function getAll(): array
    {
        // TODO: Implement getAll() method.
    }

    public function get(int $id): PostDTO
    {
        return PostDTO::fromModel(
            $this->postRepository->get($id)
        );
    }

    public function create(PostDTO $postDTO): PostDTO
    {
        // Create and save the post
        $newPost = $this->postRepository->create($postDTO);

        // Create and save the attached genres
        $newPost->musicGenres()->sync($postDTO->genreIds);

        return PostDTO::fromModel($newPost);
    }

    public function update(int $postId, PostDTO $postDTO): PostDTO
    {
        $venue = $this->postRepository->update($postId, $postDTO);
        return PostDTO::fromModel($venue);
    }

    public function delete(int $id)
    {
        return $this->postRepository->delete($id);
    }

    public function draw(array $data): array
    {
        $user = auth()->user();
        // PostPolicy
        if ($user->cannot('viewAllPosts', Post::class)) {
            $data['user_only'] = $user->id;
        }

        $data['columns'] = ['posts.name', 'posts.address'];
        $data['length'] = $data['length'] ?? 10;
        $data['column'] = $data['column'] ?? 'posts.name';
        $data['dir'] = $data['dir'] ?? 'asc';
        $data['search'] = $data['search'] ?? '';
        $data['draw'] = $data['draw'] ?? 1;

        $postsCollection = $this->postRepository->draw($data);

        $postsDTOs = $postsCollection->getCollection()->map(function ($post) {
            return PostDTO::fromModelForTable($post);
        });

        return [
            'data' => $postsDTOs,
            'pagination' => $postsCollection->toArray()['pagination'],
        ];
    }

    public function uploadAvatar(int $postId, Request $request): PostDTO
    {
        $request->validate([
            'post_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // Clear the existing 'post_image' collection and upload the new post image.
        $this->postRepository->clearPostImage($postId);
        $post =$this->postRepository->uploadPostImage($postId, $request->file('post_image'));
        return PostDTO::fromModel($post);
    }
}
