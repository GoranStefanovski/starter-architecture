<?php

namespace App\Applications\Ticket\DTO;

use Illuminate\Http\Request;
use App\Applications\Ticket\Model\Ticket;

class TicketDTO
{
    public ?int $id;
    public ?int $event_id;
    public string $type;
    public float $price;
    public int $quantity;
    public ?string $sale_start;
    public ?string $sale_end;

    private ?Ticket $model = null;

    public function __construct(
        string $type,
        float $price,
        int $quantity,
        ?string $sale_start,
        ?string $sale_end,
        ?int $id = null,
        ?int $event_id = null,
        ?Ticket $model = null
    ) {
        $this->type = $type;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->sale_start = $sale_start;
        $this->sale_end = $sale_end;
        $this->id = $id;
        $this->event_id = $event_id;
        $this->model = $model;
    }

    public static function fromRequest(Request $request): self
    {
        $ticketData = $request->input('ticket', []);

        return new self(
            $ticketData['type'],
            (float) $ticketData['price'],
            (int) $ticketData['quantity'],
            $ticketData['sale_start'] ?? null,
            $ticketData['sale_end'] ?? null,
            $ticketData['id'] ?? null,
            $ticketData['event_id'] ?? null
        );
    }

    public static function fromModel(Ticket $ticket): self
    {
        return new self(
            $ticket->type,
            $ticket->price,
            $ticket->quantity,
            $ticket->sale_start,
            $ticket->sale_end,
            $ticket->id,
            $ticket->event_id,
            $ticket
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'event_id' => $this->event_id,
            'type' => $this->type,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'sale_start' => $this->sale_start,
            'sale_end' => $this->sale_end,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['type'],
            (float) $data['price'],
            (int) $data['quantity'],
            $data['sale_start'] ?? null,
            $data['sale_end'] ?? null,
            $data['id'] ?? null,
            $data['event_id'] ?? null
        );
    }

    public function model(): Ticket
    {
        if (!$this->model) {
            throw new \LogicException('No Ticket model instance is set on this DTO.');
        }

        return $this->model;
    }
}
