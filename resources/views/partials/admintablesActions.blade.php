{{-- @can($viewGate)
    <a class="btn btn-xs btn-primary" href="{{ route('admin.' . $crudRoutePart . '.show', $row->id) }}">
        {{ trans('global.view') }}
    </a>
@endcan --}}

<button class="btn btn-xs btn-success button-accept" data-id="{{ $row->id }}">Accept</button>
<button class="btn btn-xs btn-primary button-driver" data-id="{{ $row->id }}">Choose Driver</button>
