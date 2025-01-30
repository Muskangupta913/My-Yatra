function initializeAirportSearch() {
    const searchConfig = [
        {
            inputId: '#flightFromCity',
            codeInputId: '#flightFromCityCode',
            listId: '#flightFromCityList'
        },
        {
            inputId: '#flightToCity',
            codeInputId: '#flightToCityCode',
            listId: '#flightToCityList'
        }
    ];

    // Add a single document click handler
    $(document).on('mouseup', function(e) {
        const fromList = $('#flightFromCityList');
        const toList = $('#flightToCityList');
        const fromInput = $('#flightFromCity');
        const toInput = $('#flightToCity');

        // For "From" field
        if (!fromInput.is(e.target) && !fromList.is(e.target) && fromList.has(e.target).length === 0) {
            fromList.hide();
        }

        // For "To" field
        if (!toInput.is(e.target) && !toList.is(e.target) && toList.has(e.target).length === 0) {
            toList.hide();
        }
    });

    searchConfig.forEach(config => {
        const input = $(config.inputId);
        const codeInput = $(config.codeInputId);
        const list = $(config.listId);
        let searchTimeout;

        input.on('input', function() {
            clearTimeout(searchTimeout);
            const query = $(this).val();

            if (query.length < 2) {
                list.hide();
                return;
            }

            searchTimeout = setTimeout(() => {
                fetchAirports(query, list, input, codeInput);
            }, 300);
        });
    });
}