<?php

use App\Core\Application;

Application::$app->template->layout('layouts.app');
?>

<?php Application::$app->template->section('content'); ?>
<section class="list-work">
    <div class="container">
        <div class="add-work text-end my-4">
            <a class="btn btn-primary ms-auto me-5" href="/work/calendar">View Calendar</a>
            <a class="btn btn-success ms-auto" href="/work/create">Add Work</a>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Work Name</th>
                    <th scope="col">Starting Date</th>
                    <th scope="col">Ending Date</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($works as $work) : ?>
                    <tr>
                        <th scope="row"><?= $work['id']; ?></th>
                        <td><?= $work['work_name']; ?></td>
                        <td><?= $work['starting_date']; ?></td>
                        <td><?= $work['ending_date']; ?></td>
                        <td><?= getStatusWork($work['status']); ?></td>
                        <td style="width: 15%">
                            <a class="btn btn-primary" href="<?= '/work/' . $work['id'] . '/edit'; ?>">Edit</a>
                            <button type="button" class="btn btn-danger show-modal-delete" data-bs-toggle="modal" data-bs-target="#deleteWorkModal" data-id="<?= $work['id']; ?>">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<div class="modal fade show" id="deleteWorkModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteWorkModal">Delete Work</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form id="form-delete" action="" method="post">
                    <button type="submit" class="btn btn-danger accept-delete">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php Application::$app->template->end(); ?>

<?php Application::$app->template->section('js'); ?>
<script>
    $(document).ready(() => {
        $(".show-modal-delete").click(function() {
            const id = $(this).data("id");
            const action = `work/${id}/delete`;
            $("form#form-delete").attr("action", action);
        });
    });
</script>
<?php Application::$app->template->end(); ?>