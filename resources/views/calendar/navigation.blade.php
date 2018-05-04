<form action="/calendar">
    <input type="hidden" name="date" value="{{ $calendar->date->format('dmY') }}">
    <input type="hidden" name="display" value="{{ $calendar->display }}">

    <button name="navigate" value="today" class="btn btn-primary">Today</button>
    <button name="navigate" value="prev" class="btn btn-primary">Prev</button>
    <button name="navigate" value="next" class="btn btn-primary">Next</button>
</form>