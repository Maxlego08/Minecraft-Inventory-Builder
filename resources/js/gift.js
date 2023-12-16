window.addEventListener('load', function () {

    let elementInput = document.getElementById('giftCode')
    let elementGift = document.getElementById('gift')
    let elementPrice = document.getElementById('price')
    let elementGiftTable = document.getElementById('giftTable')

    if (elementInput == null) return

    let price = Number(elementPrice.getAttribute('data-price'))

    let numberFormat = new Intl.NumberFormat('en-US', {
        maximumFractionDigits: 2,
        minimumFractionDigits: 2,
    })

    elementInput.addEventListener('change', function (event) {
        let text = event.target.value

        let url = elementInput.getAttribute('data-url').replace("%code%", text);
        axios.get(url).then(function (result) {
            let reduction = result.data.reduction
            let priceReduction = (price * reduction) / 100
            let resultReduction = numberFormat.format(priceReduction)
            let resultPrice = numberFormat.format(price - priceReduction)
            elementGift.innerText = resultReduction
            elementPrice.innerText = resultPrice

            elementInput.classList.remove("is-invalid")
            elementInput.classList.add("is-valid")
            elementGiftTable.style.display = "contents"

        }).catch(function (error) {
            elementInput.classList.add("is-invalid")
            elementInput.classList.remove("is-valid")
            elementPrice.innerText = `${price}`
            elementGift.innerText = "0"
            elementGiftTable.style.display = "none"
        })
    })

});
