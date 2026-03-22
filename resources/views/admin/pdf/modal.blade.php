<x-wire-modal-card wire:model="form.open" width='lg'>
  <p class="text-lg text-center mb-2">
    Enviar email
  </p>
  <p class="text-lg text-center uppercase mb-2">
    {{$form['document']}}
  </p>
  <p class="text-center uppercase mb-2">
    {{$form['client']}}
  </p>
  <form
    class="grid gap-4"
    wire:submit="sendEmail()"
  >
    <x-wire-input
      type='email'
      label="Correo electrónico"
      wire:model="form.email"
    />

    <x-wire-button type="submit">
      Enviar email
    </x-wire-button>
  </form>
</x-wire-modal-card>