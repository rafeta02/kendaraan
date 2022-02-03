@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="{{ $settings1['column_class'] }}">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value">{{ number_format($settings1['total_number']) }}</div>
                                    <div>{{ $settings1['chart_title'] }}</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        <div class="{{ $settings2['column_class'] }}">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value">{{ number_format($settings2['total_number']) }}</div>
                                    <div>{{ $settings2['chart_title'] }}</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        @can('is_adminlppm')
                        {{-- Widget - latest entries --}}
                        <div class="{{ $settings4['column_class'] }}" style="overflow-x: auto;">
                            <h3>{{ $settings4['chart_title'] }}</h3>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        @foreach($settings4['fields'] as $key => $value)
                                            <th>
                                                {{ trans(sprintf('cruds.%s.fields.%s', $settings4['translation_key'] ?? 'pleaseUpdateWidget', $key)) }}
                                            </th>
                                        @endforeach
                                        <th>
                                            Status
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($settings4['data'] as $entry)
                                        <tr>
                                            @foreach($settings4['fields'] as $key => $value)
                                                <td>
                                                    @if($value === '')
                                                        {{ $entry->{$key} }}
                                                    @elseif(is_iterable($entry->{$key}))
                                                        @foreach($entry->{$key} as $subEentry)
                                                            <span class="label label-info">{{ $subEentry->{$value} }}</span>
                                                        @endforeach
                                                    @else
                                                        {{ data_get($entry, $key . '.' . $value) }}
                                                    @endif
                                                </td>
                                            @endforeach
                                            <td>
                                                @if($entry->status == 'selesai')
                                                    <span class="badge badge-dark">Dikembalikan :<br>{{ $entry->date_return_formatted }}</span>
                                                @elseif ($entry->status == 'ditolak')
                                                    <span class="badge badge-dark">Ditolak dg alasan :<br>({{ $entry->status_text }})</span>
                                                @else
                                                    <span class="badge badge-{{ App\Models\Pinjam::STATUS_BACKGROUND[$entry->status] ?? '' }}">{{ App\Models\Pinjam::STATUS_SELECT[$entry->status] ?? '' }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-block btn-primary" href="{{ route('admin.process.index') }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="{{ count($settings4['fields']) }}">{{ __('No entries found') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @endcan
                        <div class="{{ $chart3->options['column_class'] }}">
                            <h3>{!! $chart3->options['chart_title'] !!}</h3>
                            {!! $chart3->renderHtml() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>{!! $chart3->renderJs() !!}
@endsection