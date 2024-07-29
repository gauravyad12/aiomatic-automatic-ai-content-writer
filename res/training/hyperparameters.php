<?php
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
if(isset($aiomatic_data->n_epochs))
{
?>
<p><strong>Epochs: </strong><?php echo esc_html($aiomatic_data->n_epochs);?></p>
<?php
}
if(isset($aiomatic_data->batch_size))
{
?>
<p><strong>Batch size: </strong><?php echo esc_html($aiomatic_data->batch_size);?></p>
<?php
}
if(isset($aiomatic_data->prompt_loss_weight))
{
?>
<p><strong>Prompt loss weight: </strong><?php echo esc_html($aiomatic_data->prompt_loss_weight);?></p>
<?php
}
if(isset($aiomatic_data->learning_rate_multiplier))
{
?>
<p><strong>Learning rate multiplier: </strong><?php echo esc_html($aiomatic_data->learning_rate_multiplier);?></p>
<?php
}
?>
