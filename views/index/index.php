<?php

/** @var string[] $fileNames */
?>

<p>
    Saved files
</p>
<table class="table table-striped table-bordered table-sm" style="width: 100%;">
    <tr>
        <th>filename</th>
    </tr>
    <?php foreach ($fileNames as $fileName) : ?>
        <tr>
            <td><?= $fileName ?></td>
        </tr>
    <?php endforeach; ?>
</table>