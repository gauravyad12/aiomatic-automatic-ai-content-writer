<?php
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="aiomatic-modal-content">
    <?php
    if(isset($aiomatic_data) && is_object($aiomatic_data)):
        ?>
        <table class="wp-list-table widefat fixed striped table-view-list comments">
            <thead>
            <tr>
                <th>Object</th>
                <th>ID</th>
                <th>Created At</th>
                <th>Model</th>
                <th>Trained Tokens</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo esc_html($aiomatic_data->object)?></td>
                    <td><?php echo esc_html($aiomatic_data->id)?></td>
                    <td><?php echo esc_html(date('Y-m-d H:i:s',$aiomatic_data->created_at))?></td>
                    <td><?php echo esc_html($aiomatic_data->model)?></td>
                    <td><?php echo esc_html($aiomatic_data->trained_tokens)?></td>
                </tr>
            </tbody>
        </table>
    <?php
    else:
        ?>
        No events
    <?php
    endif;
    ?>

</div>
