@push('styles')
<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
<link href="{{ asset('frontend/css/simplePagination.css') }}" rel="stylesheet">
<style>
    .wrapper {
        padding: 2rem 2rem 0 2rem;
        max-width: 576px;
        width: 100%;
        border-radius: 0.75rem;
        box-shadow: var(--shadow);
        text-align: center;
        background: #10ab8d0f;
        margin-top: 20px;
    }

    .bx {
        color: #ffb321;
    }

    .wrapper h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .rating {
        display: flex;
        align-items: center;
        grid-gap: .5rem;
        font-size: 2rem;
        color: var(--yellow);
    }

    .rating .star {
        cursor: pointer;
    }

    .rating .star.active {
        opacity: 0;
        animation: animate .5s calc(var(--i) * .1s) ease-in-out forwards;
    }

    @keyframes animate {
        0% {
            opacity: 0;
            transform: scale(1);
        }

        50% {
            opacity: 1;
            transform: scale(1.2);
        }

        100% {
            opacity: 1;
            transform: scale(1);
        }
    }


    .rating .star:hover {
        transform: scale(1.1);
    }

    textarea {
        width: 100%;
        background: var(--light);
        padding: 1rem;
        border-radius: .5rem;
        /* border: none;
	outline: none; */
        border-color: #79554830;
        resize: none;
        margin-bottom: .5rem;
    }

    .btn-group {
        display: flex;
        grid-gap: .5rem;
        align-items: center;
    }

    .btn-group .btn {
        padding: .75rem 1rem;
        border-radius: .5rem;
        border: none;
        outline: none;
        cursor: pointer;
        font-size: .875rem;
        font-weight: 500;
    }

    .btn-group .btn.submit {
        background: #0e947a;
        color: white;
    }

    .btn-group .btn.submit:hover {
        background: #3d6f65;
    }

    .btn-group .btn.cancel {
        background: #cb1111;
        color: white;
    }

    .btn-group .btn.cancel:hover {
        background: #9f0d0d;
    }
    .dropMeUploader .preview .previewImage {
        width: calc(18% - 1rem) !important;
        padding-bottom: calc(20% - 1rem) !important;
    }
</style>
@endpush

@push('scripts')
<script>
    const allStar = document.querySelectorAll('.rating .star')
    const ratingValue = document.querySelector('.rating input')
    const close = document.querySelector('.cancel')

    allStar.forEach((item, idx) => {
        item.addEventListener('click', function () {
            let click = 0
            ratingValue.value = idx + 1

            allStar.forEach(i => {
                i.classList.replace('bxs-star', 'bx-star')
                i.classList.remove('active')
            })
            for (let i = 0; i < allStar.length; i++) {
                if (i <= idx) {
                    allStar[i].classList.replace('bx-star', 'bxs-star')
                    allStar[i].classList.add('active')
                } else {
                    allStar[i].style.setProperty('--i', click)
                    click++
                }
            }
        })
    });

    close.addEventListener('click', function () {
        allStar.forEach(i => {
                i.classList.replace('bxs-star', 'bx-star')
                i.classList.remove('active')
            })
    });
</script>

<script type="text/javascript" src="{{ asset('frontend/js/jquery.simplePagination.js') }}"></script>
<script>

var items = $(".list-wrapper .list-item");
    var numItems = items.length;
    var perPage = 3;

    items.slice(perPage).hide();

    $('#pagination-container').pagination({
        items: numItems,
        itemsOnPage: perPage,
        prevText: "&laquo;",
        nextText: "&raquo;",
        onPageClick: function (pageNumber) {
            var showFrom = perPage * (pageNumber - 1);
            var showTo = showFrom + perPage;
            items.hide().slice(showFrom, showTo).show();
        }
    });
</script>

@endpush