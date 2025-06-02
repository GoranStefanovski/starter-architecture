<?php

namespace App\Applications\Event\Repositories;

use App\Applications\Pagination\StarterPaginator;
use App\Applications\Event\DTO\EventDTO;
use App\Applications\Event\Model\Event;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Interface EventRepositoryInterface
 * @package App\Applications\Event
 */
interface EventRepositoryInterface{
    /**
     * @return array
     */
    public function getAll(): array;

    /**
     * @param integer $id
     * @return Event
     */
    public function get($id): Event;

    /**
     * @param EventDTO $eventDTO
     * @return Event
     */
    public function create(EventDTO $eventDTO): Event;

    /**
     * @param int $eventId
     * @param EventDTO $eventData
     * @return Event
     */
    public function update(int $eventId, EventDTO $eventData): Event;

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
     * Clear the avatar collection for a given user.
     *
     * @param Event $event
     * @return void
     */
    public function clearVenueAvatars(Event $event): void;

    /**
     * Upload a new avatar for a given user.
     *
     * @param Event $event
     * @param UploadedFile $file
     * @return Media
     */
    public function uploadAvatar(Event $event, UploadedFile $file): Media;
}
