<table {{ $attributes->merge(['class' => 'table table-striped dt-responsive table-responsive nowrap mt-3']) }}>
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