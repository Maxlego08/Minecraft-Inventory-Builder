<div class="card mb-4">
    <div class="card-body">
        <form action="#" method="get" class="mb-4">
            @method('GET')
            @csrf
            <div class="mb-3">
                <label for="search" class="form-label ms-3">Rechercher un acheteur</label>
                <input type="text" class="form-control" id="search">
            </div>

            <div class="row row-cols-lg-3">
                @for ($i = 0; $i < 24; $i++)
                    <div class="d-flex my-2">
                        <a href="https://groupez.dev/resources/authors/maxlego08.1"
                           title="Maxlego08 profile">
                            <img class=" rounded-circle"
                                 src="https://groupez.dev/storage/images/users/0/0/0/1.png"
                                 alt="Maxlego08 Avatar">
                        </a>
                        <div class="ms-3">
                            <a href="#" class="fw-bold text-decoration-none d-block" title="anonymuser0023">anonymuser0023</a>
                            <span>2 août 2022</span>
                        </div>
                    </div>
                @endfor
            </div>
        </form>
    </div>
</div>
