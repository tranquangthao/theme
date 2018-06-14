<footer>
    <section class="slogan-main">
        <div class="col-md-8 col-md-offset-2">
            <h5>{{$labels[17]->name}}</h5>
            <p class="slogan wow bounce">{!! $labels[18]->name !!}</p>
        </div>
        <div style="clear: both"></div>
    </section>
    {!! \App\Http\Controllers\Controller::getAddress() !!}
</footer>