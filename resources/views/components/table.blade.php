<div class="table-responsive">
<table {{ $attributes->merge(['class' => 'table table-striped dt-responsive table-responsive nowrap']) }}>
    @isset($thead)
    <thead class="bg-primary">
        <tr>
            {{ $thead }}
        </tr>
    </thead>
    @endisset

    <tbody>
        <tr>
            {{ $slot }}
        </tr>
    </tbody>

    @isset($tfoot)
    <tfoot>
        {{ $tfoot }}
    </tfoot>
    @endisset
</table>
</div>