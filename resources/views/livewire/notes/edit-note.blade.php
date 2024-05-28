<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Note;

new #[Layout('layouts.app')] class extends Component {
    public Note $note;

    public $noteTitle;
    public $noteBody;
    public $noteRecipient;
    public $noteSendDate;
    public $isPublished;

    public function mount(Note $note)
    {
        $this->authorize('update', $note);
        $this->fill($note);
        $this->noteTitle = $note->title;
        $this->noteBody = $note->body;
        $this->noteRecipient = $note->recipient;
        $this->noteSendDate = $note->send_date;
        $this->isPublished = $note->is_published;
    }

    public function saveNote()
    {
        $validated = $this->validate([
            'noteTitle' => ['required', 'string', 'min:5'],
            'noteBody' => ['required', 'string', 'min:20'],
            'noteRecipient' => ['required', 'email'],
            'noteSendDate' => ['required', 'date'],
        ]);

        $this->note->update([
            'title' => $this->noteTitle,
            'body' => $this->noteBody,
            'recipient' => $this->noteRecipient,
            'send_date' => $this->noteSendDate,
            'is_published' => $this->isPublished,
        ]);

        $this->dispatch('note-saved');
    }
}; ?>


<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Editar anotação') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-2xl mx-auto space-y-4 sm:px-6 lg:px-8">
        <form wire:submit="saveNote" class="space-y-4">
            <x-input wire:model="noteTitle" label="Título" placeholder="Lista de compras" />
            <x-textarea wire:model="noteBody" label="Sua anotação" placeholder="Arroz, Feijão, Frango..." />
            <x-input icon="user" wire:model="noteRecipient" label="Destinatário" placeholder="fulano@gmail.com" type="email" />
            <x-input icon="calendar" wire:model="noteSendDate" label="Data de Envio" type="date" />
            <x-checkbox label="Publicada" wire:model="isPublished" />
            <div class="flex justify-between pt-4">
                <x-button type="submit" secondary spinner="saveNote">Salvar</x-button>
                <x-button href="{{ route('notes.index') }}" flat negative >Voltar para anotações</x-button>
            </div>
            <x-action-message on="note-saved" />
            <x-errors />
        </form>
    </div>
</div>
