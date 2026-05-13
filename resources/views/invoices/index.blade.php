<x-app-layout>
  <h1>{{ __('Sąskaitos') }}</h1>

  @include("components.search_buttons", ["createNew" => route("invoices.create"), "filter" => ""])

  <table>
    <tr>
      <th>{{ __('Dokumento Data') }}</th>
      <th>{{ __('Darbuotojas') }}</th>
      <th>{{ __('Apmokėta') }}</th>
      <th class="w-1/8 text-right">{{ __('Veiksmai') }}</th>
    </tr>
    @foreach($items as $item)

    <tr data-tr="{{ __('Sąskaita') }} {{ $item->id }}">
      <td data-th="{{ __('Dokumento Data') }}">{{ $item->document_date }}</td>
      <td data-th="{{ __('Darbuotojas') }}">{{ $item->contrahent_name }}</td>
      <td data-th="{{ __('Apmokėta') }}">
        @if($item->paid)
          {{ __('Taip') }}
        @else
          {{ __('Ne') }}
        @endif
      </td>
      <td data-th="{{ __('Veiksmai') }}">
          @unless($item->paid)
            <form action="{{ route('invoices.mark-paid', $item) }}" method="POST" class="d-inline">
              @csrf
              @method("PATCH")
              <button type="submit" class="btn site-helpers__links color-persian-green">
                {{ __('Pažymėti apmokėta') }}
              </button>
            </form>
          @endunless

          @include("partials.actions", [
            'item' => $item,
            'editRoute' => "invoices.edit",
            'showRoute' => "invoices.read",
          ])

        </td>
    </tr>
    @endforeach
  </table>
</x-app-layout>
