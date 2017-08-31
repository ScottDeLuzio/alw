<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/* Setup the Dashboard. */
add_action( 'wp_dashboard_setup', 'alw_input_dashboard_widget' );
 
/* Add Dashboard Widget */
function alw_input_dashboard_widget(){
	wp_add_dashboard_widget( 'alw-games-id', 'Your Games', 'alw_widget_callback', 'alw_widget_control_callback' );
}
 
/* Widget HTML Output */
function alw_widget_callback(){
	?>
		<p>Your games:</p>
		<?php
		$games = get_option( 'alw_games' );
		if ( $games ){
			echo '<ul>';
			foreach( $games as $game ){
				echo '<li><a href="' . $game['url'] . '">' . $game['name'] . '</a>';
			}
			echo '</ul>';
		}
		?>

	<?php
}
 
/* Widget Configuration */
function alw_widget_control_callback(){
	//Get widget options
	if ( !$alw_widget_options = get_option( 'alw_games' ) )
		$alw_widget_options = array();
 
	//On form submit, prepare input and save if valid.
	if( isset( $_POST['alw-games'] ) ){
		$games 	= $_POST['alw-games'];
		$save 	= array();
		foreach ( $games as $game ){
			if ( $game['name'] && $game['url'] ){
				//Make data safe for input
				$name 	= sanitize_text_field( $game['name'] );
				$url 	= esc_url( $game['url'], array( 'http', 'https' ) );
				
				//Both the name and url need to be entered
				if( $name != '' && $url != '' )
					$save[] = array( 'name' => $name, 'url' => $url );
			}
		}
		update_option( 'alw_games', $save );
	}

	$new_key = 0;
	if( $alw_widget_options ){
		foreach ( $alw_widget_options as $key => $value ) { 
			$row = 'alw-odd';
			if ( $key % 2 == 0 ){
				$row = 'alw-even';
			}
			?>
			<div class="<?php echo $row; ?>">
				<div class="alw-container">
					<label for="alw-input-name">Enter the name of your game:</label>
					<input id="alw-input-name" class="widefat" name="alw-games[<?php echo $key; ?>][name]" type="text" value="<?php echo esc_attr( $value['name'] ); ?>" />
				</div>
				<div class="alw-container">
					<label for="alw-input-url">Enter the link to your game:</label>
					<input id="alw-input-url" class="widefat" name="alw-games[<?php echo $key; ?>][url]" type="text" placeholder="http://" value="<?php echo esc_attr( $value['url'] ); ?>" />
				</div>
			</div>
			<?php
			$new_key = $key + 1;
		}
	}
	$new_row = 'alw-odd';
	if( $new_key % 2 == 0 ){
		$new_row = 'alw-even';
	}
	?>

	<div class="<?php echo $new_row; ?>">
		<div class="alw-container">
			<label for="alw-input-name">Name of your new game:</label>
			<input id="alw-input-name" class="widefat" name="alw-games[<?php echo $new_key; ?>][name]" type="text" />
		</div>
		<div class="alw-container">
			<label for="alw-input-url">Link to your new game:</label>
			<input id="alw-input-url" class="widefat" name="alw-games[<?php echo $new_key; ?>][url]" type="text" placeholder="http://" />
		</div>
	</div>
	<?php
}