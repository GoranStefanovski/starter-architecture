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
     * @param EventDTO $eventDTO
     * @return Event
     */
    public function update(int $eventId, EventDTO $eventDTO): Event;

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
     * Clear the event_image collection for a given event.
     *
     * @param integer $eventId
     * @return void
     */
    public function clearEventImage(int $eventId): void;

    /**
     * Upload a new event_image for a given Event.
     *
     * @param integer $eventId
     * @param UploadedFile $file
     * @return Event
     */
    public function uploadEventImage(int $eventId, UploadedFile $file): Event;
}
