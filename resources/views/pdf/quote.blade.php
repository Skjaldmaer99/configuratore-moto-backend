<h1>Preventivo Moto {{ $configuration->model->name }} {{ $configuration->engine->name }},</h1>

<p>
    Modello:
    {{ $configuration->model->name }} €{{ $configuration->model->base_price }}
</p>

<p>
    Colore:
    {{ $configuration->color->name }} €{{ $configuration->color->extra_price }}
</p>

<p>
    {{ $configuration->engine->displacement_cc }} cc,
    {{ $configuration->engine->cylinders }} cilindri,
    {{ $configuration->engine->engine_type }},
    {{ $configuration->engine->horsepower }} CV,
    cambio {{ $configuration->engine->gearbox ?? 'non specificato' }},
    alimentazione {{ $configuration->engine->fuel_type }}.
</p>
<p>Costo variante motore: € {{ number_format($configuration->engine->extra_price, 2, ',', '.') }}.</p>

<h2>Optional</h2>

<ul>
    @foreach($configuration->optionals as $optional)
        <li>
            {{ $optional->name }} €{{ $optional->price }}
        </li>
    @endforeach
</ul>

<h2>Accessori</h2>

<ul>
    @foreach($configuration->accessories as $accessory)
        <li>
            {{ $accessory->name }} €{{ $accessory->price }}
        </li>
    @endforeach
</ul>

<h2>
    Totale:
    €{{ $configuration->total_price }}
</h2>