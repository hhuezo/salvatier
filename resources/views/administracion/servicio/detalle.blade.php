<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Fecha Pago</th>
            <th scope="col">Monto</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total = 0;
        @endphp

        @foreach ($pagos as $pago)
            @php
                $total += $pago['monto'];
            @endphp
            <tr>
                <th scope="row">{{ $pago['numero'] }}</th>
                <td>
                    {{ isset($pago['fecha']) && $pago['fecha'] ? \Carbon\Carbon::parse($pago['fecha'])->format('d/m/Y') : '-' }}
                </td>
                <td>${{ number_format($pago['monto'], 2) }}</td>
            </tr>
        @endforeach

        <tr>
            <th colspan="2" class="text-end">Total</th>
            <th>${{ number_format($total, 2) }}</th>
        </tr>
    </tbody>

    <tr>
        <th colspan="3" class="text-end"> <button type="button" id="btnGuardar" class="btn btn-primary"
                onclick="store()">Aceptar</button></th>
    </tr>
</table>
