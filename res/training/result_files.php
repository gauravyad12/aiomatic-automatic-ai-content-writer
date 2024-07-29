<?php
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="aiomatic-modal-content">
<?php
if(isset($aiomatic_data) && is_array($aiomatic_data) && count($aiomatic_data)):
?>
<table class="wp-list-table widefat fixed striped table-view-list comments">
    <thead>
    <tr>
        <th>ID</th>
        <th>Purpose</th>
        <th>Created At</th>
        <th>Filename</th>
        <th>Status</th>
        <th>Download</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach($aiomatic_data as $item)
    {
        if(is_object($item))
        {
        ?>
        <tr>
            <td><?php echo esc_html($item->id)?></td>
            <td><?php echo esc_html($item->purpose)?></td>
            <td><?php echo esc_html(date('Y-m-d H:i:s',$item->created_at))?></td>
            <td><?php echo esc_html($item->filename)?></td>
            <td><?php echo esc_html($item->status)?></td>
            <td><a download="download" href="<?php echo admin_url('admin-ajax.php?action=aiomatic_download&id='.$item->id)?>">Download</a></td>
        </tr>
        <?php
        }
        else
        {
        ?>
            <tr>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td><?php echo esc_html(print_r($item, true))?></td>
                <td>-</td>
                <td>-</td>
            </tr>
        <?php
        }
    }
    ?>
    </tbody>
</table>
<?php
else:
?>
Fine-tuning has not yet been completed.
<?php
endif;
?>
</div>
