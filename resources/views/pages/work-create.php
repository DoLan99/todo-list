<?php
use App\Core\Application;

Application::$app->template->layout('layouts.app');
?>

<?php Application::$app->template->section('content'); ?>
<section class="create-work">
    <div class="container">
        <form action="/work" method="post">
            <div class="mb-3">
                <label class="form-label">Work Name</label>
                <input type="text" class="form-control" name="work_name" value="<?= $olds['work_name'] ?? null; ?>">
                <div class="text-danger">
                    <?= $errors['work_name'] ?? ''; ?>
                </div>
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Starting Date</label>
                        <input type="text" id="date-start" autocomplete="off" class="form-control" name="starting_date" value="<?= $olds['starting_date'] ?? null; ?>">
                        <div class="text-danger">
                            <?= $errors['starting_date'] ?? ''; ?>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Ending Date</label>
                        <input type="text" id="date-end" autocomplete="off" class="form-control" name="ending_date"  value="<?= $olds['ending_date'] ?? null; ?>">
                        <div class="text-danger">
                            <?= $errors['ending_date'] ?? ''; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option <?= !empty($olds['status']) ? 'selected' : ''; ?> value="" disabled>Select status</option>
                            <?php foreach(WORK_STATUS as $key => $value): ?>
                                <option <?= (!empty($olds['status']) && $olds['status'] == $value) ? 'selected' : ''; ?> value="<?= $value; ?>"><?= $key; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="text-danger">
                            <?= $errors['status'] ?? ''; ?>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Submit</button>
        </form>
    </div>
</section>
<?php Application::$app->template->end(); ?>

<?php Application::$app->template->section('js'); ?>
<script>
    $(document).ready(() => {
        $("#date-start").datepicker({
            format: "yyyy-mm-dd",
        });

        $("#date-end").datepicker({
            format: "yyyy-mm-dd",
        });
    });
</script>
<?php Application::$app->template->end(); ?>