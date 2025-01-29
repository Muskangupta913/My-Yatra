<style>
.seat-map-container {
    width: 100%;
    max-width: 900px;
    margin: 0 auto;
    padding: 1rem;
    font-family: Arial, sans-serif;
    background: #f8f9fa;
    box-sizing: border-box;
}

.flight-info {
    width: 100%;
    background: white;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.flight-info h5 {
    color: #2c3e50;
    font-size: 1.1rem;
    margin: 0 0 0.5rem 0;
}

.flight-info p {
    color: #576574;
    margin: 0 0 0.25rem 0;
    font-size: 0.9rem;
}

.seat-grid {
    display: grid;
    grid-template-columns: repeat(7, minmax(35px, 1fr));
    gap: 0.5rem;
    padding: 1.5rem 1rem;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    position: relative;
    width: 100%;
    box-sizing: border-box;
    margin: 2rem auto;
}

.seat-grid::before {
    content: '';
    position: absolute;
    top: -20px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 20px;
    background: #f1f2f3;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
}

.seat-grid::after {
    content: '';
    position: absolute;
    bottom: -15px;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 15px;
    background: #f1f2f3;
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
}

.aisle-gap {
    width: 1rem;
}

.seat {
    aspect-ratio: 1;
    width: 100%;
    min-width: 35px;
    max-width: 50px;
    border: 2px solid #e4e7eb;
    border-radius: 6px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    position: relative;
    background: white;
    transition: all 0.2s ease;
    padding: 0.25rem;
    box-sizing: border-box;
}

.seat:not(.booked):hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    z-index: 2;
}

.seat.booked {
    background: #f5f6f7;
    border-color: #e1e1e1;
    cursor: not-allowed;
}

.seat.legroom {
    border-color: #2ecc71;
}

.seat.aisle {
    border-color: #3498db;
}

.seat-number {
    font-weight: 600;
    font-size: 0.9rem;
    color: #2d3436;
    text-align: center;
}

.booked .seat-number {
    color: #a4acb3;
}

.seat-price {
    position: absolute;
    top: -30px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(45, 52, 54, 0.9);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.7rem;
    display: none;
    white-space: nowrap;
    z-index: 10;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.seat:not(.booked):hover .seat-price {
    display: block;
}

.seat-legend {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 1rem;
    padding: 1rem;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    margin-top: 2rem;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    justify-content: center;
}

.legend-box {
    width: 16px;
    height: 16px;
    border: 2px solid;
    border-radius: 4px;
    flex-shrink: 0;
}

.legend-item span {
    color: #576574;
    font-size: 0.8rem;
    white-space: nowrap;
}

@media (max-width: 480px) {
    .seat-map-container {
        padding: 0.5rem;
    }

    .seat-grid {
        grid-template-columns: repeat(7, minmax(30px, 1fr));
        gap: 0.25rem;
        padding: 1rem 0.5rem;
    }

    .seat {
        min-width: 30px;
    }

    .seat-number {
        font-size: 0.8rem;
    }

    .aisle-gap {
        width: 0.5rem;
    }

    .seat-legend {
        grid-template-columns: repeat(2, 1fr);
        gap: 0.5rem;
        padding: 0.75rem;
    }

    .legend-item {
        font-size: 0.7rem;
    }

    .legend-box {
        width: 14px;
        height: 14px;
    }
}

@media (max-width: 360px) {
    .seat-grid {
        grid-template-columns: repeat(7, minmax(25px, 1fr));
        gap: 0.2rem;
    }

    .seat {
        min-width: 25px;
    }

    .seat-number {
        font-size: 0.7rem;
    }
}
</style>

<div class="seat-map-container">
    @if(isset($flightInfo))
    <div class="flight-info">
        <h5>{{ $flightInfo['airline'] }}</h5>
        <p>{{ $flightInfo['from'] }} → {{ $flightInfo['to'] }}</p>
        <p>{{ $flightInfo['airlineCode'] }}-{{ $flightInfo['airlineNumber'] }}</p>
    </div>
    @endif

    <div class="seat-grid">
        @php
            $currentRow = '';
            $maxRow = max(array_map(function($seat) {
                return $seat['Row'];
            }, $availableSeats));
        @endphp

        @for ($row = 1; $row <= $maxRow; $row++)
            @for ($col = 1; $col <= 7; $col++)
                @php
                    $currentSeat = null;
                    foreach ($availableSeats as $seat) {
                        if ($seat['Row'] == $row && $seat['Column'] == $col) {
                            $currentSeat = $seat;
                            break;
                        }
                    }
                @endphp

                @if ($col == 4)
                    <div class="aisle-gap"></div>
                @else
                    @if ($currentSeat)
                        <div class="seat 
                            {{ $currentSeat['IsLegroom'] ? 'legroom' : '' }} 
                            {{ $currentSeat['IsAisle'] ? 'aisle' : '' }}"
                            onclick="selectSeat('{{ $currentSeat['Code'] }}', 
                                '{{ $currentSeat['SeatNumber'] }}', 
                                '{{ $currentSeat['Amount'] }}', 
                                '{{ $flightInfo['airlineName'] }}', 
                                '{{ $flightInfo['airlineCode'] }}', 
                                '{{ $flightInfo['airlineNumber'] }}')"
                        >
                            <span class="seat-number">{{ $currentSeat['SeatNumber'] }}</span>
                            <span class="seat-price">₹{{ number_format($currentSeat['Amount'], 2) }}</span>
                        </div>
                    @else
                        <div class="seat booked">
                            <span class="seat-number">{{ $row }}{{ chr(64 + ($col > 4 ? $col - 1 : $col)) }}</span>
                        </div>
                    @endif
                @endif
            @endfor
        @endfor
    </div>

    <div class="seat-legend">
        <div class="legend-item">
            <div class="legend-box" style="border-color: #ddd"></div>
            <span>Standard</span>
        </div>
        <div class="legend-item">
            <div class="legend-box" style="border-color: #28a745"></div>
            <span>Extra Legroom</span>
        </div>
        <div class="legend-item">
            <div class="legend-box" style="border-color: #17a2b8"></div>
            <span>Aisle Seat</span>
        </div>
        <div class="legend-item">
            <div class="legend-box" style="border-color: #ddd; background: #f5f5f5"></div>
            <span>Booked</span>
        </div>
    </div>
</div>