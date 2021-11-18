<?php
use App\Core\Application;

Application::$app->template->layout('layouts.app');
?>

<?php Application::$app->template->section('content'); ?>
<div class="container">
    <div id='calendar'></div>
</div>
<?php Application::$app->template->end(); ?>

<?php Application::$app->template->section('js'); ?>
<script>
    const works = <?= json_encode($works); ?>;
    const dataCalendar = [];

    works.forEach(work => {
        dataCalendar.push({
            id: work.id,
            title: work.work_name,
            start: work.starting_date,
            end: work.ending_date,
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const calendarEl = document.getElementById("calendar");
        const calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                center: "dayGridMonth, timeGridWeek, timeGridDay"
            },
            events: dataCalendar,
            eventColor: '#378006'
        });
        calendar.render();
    });
</script>
<?php Application::$app->template->end(); ?>