    <div class="row">
        <div class="col-md-12">
            <nav class="navbar navbar-inverse navbar-static-top">


                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                       @include('partials.items', ['items'=> $menu_start->roots()])
                    </ul>
                </div>
            </nav>
        </div>
    </div>
