<?php

namespace App\Applications\Event\Services;

use App\Applications\Event\DTO\EventDTO;
use App\Applications\Event\Model\Event;
use Illuminate\Http\Request;

/**
 * Interface EventServiceInterface
 * @package App\Applications\Event
 */

interface EventServiceInterface
{
    /**
     * @return array
     */
    public function getAll(): array;

    /**
     * @param integer $id
     * @return EventDTO
     */
    public function get(int $id): EventDTO;

    /**
     * @param EventDTO $eventDTO
     * @return EventDTO
     */
    public function create(EventDTO $eventDTO): EventDTO;

    /**
     * @param int $eventId
     * @param EventDTO $eventDTO
     * @return EventDTO
     */
    public function update(int $eventId, EventDTO $eventDTO): EventDTO;

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
     * @param int $eventId
     * @param Request $request
     * @param EventDTO $event
     * @return EventDTO
     */
    public function uploadAvatar(int $eventId, Request $request, Event $event): EventDTO;
}
