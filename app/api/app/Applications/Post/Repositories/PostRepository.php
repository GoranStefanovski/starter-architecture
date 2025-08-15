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
        'address' => 'posts.address',
        'status' => 'posts.is_disabled'
    ];

    public function getAll(): array
    {
        // TODO: Implement getAll() method.
    }

    public function get($id): Post
    {
        return $this->post::with('musicGenres','media')->findOrFail($id);
    }

    public function create(PostDTO $postDTO): Post
    {
        $attributes = $postDTO->toArray();
        //Safe Hydration (tickets and genreIds are not fillable on the Post Eloquent model)
        unset($attributes['genreIds']);
        $post = new Post($attributes);
        $post->save();
        return $post;
    }

    public function update(int $postId, PostDTO $postDTO): Post
    {
        $post = $this->post->findOrFail($postId);
        $attributes = $postDTO->toArray();
        unset($attributes['tickets']);
        $post->update($attributes);
        $post->musicGenres()->sync($postDTO->genreIds);

        $existingTicketIds = [];
        foreach ($postDTO->tickets as $ticketDTO) {
            if ($ticketDTO->id) {
                // update existing ticket
                $ticket = $post->tickets()->find($ticketDTO->id);
                if ($ticket) {
                    $ticket->update($ticketDTO->toArray());
                    $existingTicketIds[] = $ticket->id;
                }
            } else {
                // create new ticket
                $newTicket = $post->tickets()->create($ticketDTO->toArray());
                $existingTicketIds[] = $newTicket->id;
            }
        }

        //delete tickets not in current payload
        $post->tickets()->whereNotIn('id', $existingTicketIds)->delete();
        return $post;
    }

    public function delete(int $id)
    {
        return $this->post::findOrFail($id)->delete();
    }

    public function draw(array $data): StarterPaginator
    {
        //TODO: maybe pull music genres,city when filtration for those is added in the dashboard
        $query = $this->post
            ->select(['id', 'user_id', 'name', 'address', 'post_start']);

        if (!empty($data['user_only'])) {
            $query->where('user_id', $data['user_only']);
        }

        if (array_key_exists($data['column'], self::COLUMNS_MAP)) {
            $query->orderBy(self::COLUMNS_MAP[$data['column']], $data['dir']);
        }

        if (!empty($data['music_genre'])) {
            $genreIds = is_array($data['music_genre']) ? $data['music_genre'] : [$data['music_genre']];
            $query->whereHas('musicGenres', function ($q) use ($genreIds) {
                $q->whereIn('music_genres.id', $genreIds);
            });
        }

        if (!empty($data['city'])) {
            $query->where('city', $data['city']);
        }

        if (!empty($data['start_date'])) {
            $query->whereDate('post_start', '=', $data['start_date']);
        }

        $search = $data['search'];
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->where('posts.name', 'like', '%' . $search . '%');
                $subquery->orWhere('posts.address', 'like', '%' . $search . '%');
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
