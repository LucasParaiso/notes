<?php

use Livewire\Volt\Component;

new class extends Component {
    public $noteTitle;
    public $noteBody;
    public $noteRecipient;
    public $noteSendDate;

    public function submit()
    {
        $validated = $this->validate([
            'noteTitle' => ['required', 'string', 'min:5'],
            'noteBody' => ['required', 'string', 'min:20'],
            'noteRecipient' => ['required', 'email'],
            'noteSendDate' => ['required', 'date'],
        ]);

        auth()->user()->notes()->create([
            'title' => $this->noteTitle,
            'body' => $this->noteBody,
            'recipient' => $this->noteRecipient,
            'send_date' => $this->noteSendDate,
            'is_published' => true,
        ]);

        redirect(route('notes.index'));
    }
}; ?>

<div>
    <form wire:submit="submit" class="space-y-4">
        <x-input wire:model="noteTitle" label="Título" placeholder="Lista de compras" />
        <x-textarea wire:model="noteBody" label="Sua anotação" placeholder="Arroz, Feijão, Frango..." />
        <x-input icon="user" wire:model="noteRecipient" label="Destinatário" placeholder="fulano@gmail.com"
            type="email" />
        <x-input icon="calendar" wire:model="noteSendDate" label="Data de Envio" type="date" />
        <div class="pt-4">
            <x-button type="submit" primary right-icon="calendar" spinner>Enviar</x-button>
        </div>
        <x-errors />
    </form>
</div>
