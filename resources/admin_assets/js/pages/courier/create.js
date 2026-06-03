$(document).ready(function () {
    const minWeightInput = $('#min_weight');
    const maxWeightInput = $('#max_weight');
    const form = minWeightInput.closest('form');
    const maxAllowedWeight = $('#maxValue').val();

    form.on('submit', function (event) {
        const minWeight = parseFloat(minWeightInput.val());
        const maxWeight = parseFloat(maxWeightInput.val());

        if (minWeight >= maxWeight) {
            event.preventDefault();
            alert('Minimum Weight must be less than Maximum Weight and Maximum Weight must be greater than Minimum Weight.');
        } else if (minWeight > maxAllowedWeight || maxWeight > maxAllowedWeight) {
            event.preventDefault();
            alert('Minimum Weight and Maximum Weight must not exceed ' + maxAllowedWeight + '.');
        }
    });

    minWeightInput.on('input', function () {
        validateWeights();
    });

    maxWeightInput.on('input', function () {
        validateWeights();
    });

    function validateWeights() {
        const minWeight = parseFloat(minWeightInput.val());
        const maxWeight = parseFloat(maxWeightInput.val());

        if (minWeightInput.val() !== '' && maxWeightInput.val() !== '' && minWeight >= maxWeight) {
            minWeightInput[0].setCustomValidity('Minimum Weight must be less than Maximum Weight.');
            maxWeightInput[0].setCustomValidity('Maximum Weight must be greater than Minimum Weight.');
        } else if (minWeight > maxAllowedWeight) {
            minWeightInput[0].setCustomValidity('Minimum Weight must not exceed ' + maxAllowedWeight + '.');
        } else if (maxWeight > maxAllowedWeight) {
            maxWeightInput[0].setCustomValidity('Maximum Weight must not exceed ' + maxAllowedWeight + '.');
        } else {
            minWeightInput[0].setCustomValidity('');
            maxWeightInput[0].setCustomValidity('');
        }
    }
});