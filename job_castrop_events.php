<?php
/*
Plugin Name: Events Rich Snippets for Google
Plugin URI: http://www.jobcastrop.nl/events-rich-snippet-plugin-for-wordpress
Description: Create vevents for rich snippets in google
Version: 1.8
Author: Job Castrop
Author URI: http://www.jobcastrop.nl
*/

	function events_install()
	{
		global $wpdb;

		$table_name = $wpdb->prefix . "job_castrop_events";

		$sql = "CREATE TABLE " . $table_name . " (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  dtstart VARCHAR(55) DEFAULT '0000-00-00' NOT NULL,
		  dtend VARCHAR(55) DEFAULT '0000-00-00' NOT NULL,
		  summary tinytext NOT NULL,
		  description text NOT NULL,
		  url VARCHAR(255) DEFAULT '' NOT NULL,
		  location VARCHAR(255) DEFAULT '' NOT NULL,
		  buy_link VARCHAR(255) DEFAULT '' NOT NULL,
		  list mediumint(9) NOT NULL,
		  UNIQUE KEY id (id)
		);";

		$wpdb->query($sql);

		$sql = "ALTER TABLE $table_name MODIFY url VARCHAR(255) DEFAULT '' NOT NULL";

		$wpdb->query($sql);

		$sql = "ALTER TABLE $table_name MODIFY location VARCHAR(255) DEFAULT '' NOT NULL";

		$wpdb->query($sql);

		$sql = "ALTER TABLE $table_name MODIFY buy_link VARCHAR(255) DEFAULT '' NOT NULL";

		$wpdb->query($sql);

		$table_name = $wpdb->prefix . "job_castrop_event_lists";

		$sql = "CREATE TABLE " . $table_name . " (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  name VARCHAR(255) DEFAULT '' NOT NULL,
		  UNIQUE KEY id (id)
		);";

		$wpdb->query($sql);

		$sql = "ALTER TABLE $table_name MODIFY name VARCHAR(255) DEFAULT '' NOT NULL";

		$wpdb->query($sql);

		add_option('events_date_format', 'j F Y');
		add_option('events_title_head', 'Title');
		add_option('events_date_head', 'Date');
	}


	function events_overview()
	{
		$action = $_GET['action'];

		if ($action = 'delete')
		{
			$eventId = $_GET['event'];
			deleteEvent($eventId);
		}

		global $wpdb;

		$listId = $_GET['list'];

		$list = getEventList($listId);

		$table_name = $wpdb->prefix . "job_castrop_events";
		$sql = "SELECT * FROM " . $table_name;

		if ($list)
		{
			$sql .= ' WHERE list = ' . $list->id;
		}

		$result = $wpdb->get_results($sql);
		?>
	<div class="wrap">
		<div id="icon-edit-comments" class="icon32"></div>
		<h2>Events overzicht <?php if ($list) echo ': ' . $list->name; ?></h2>
		<table class="widefat">
			<thead>
			<tr>
				<th>Title</th>
				<th>Url</th>
				<th>Start date</th>
				<th>End date</th>
			</tr>
			</thead>
			<tfoot>
			<tr>
				<th>Title</th>
				<th>Url</th>
				<th>Start date</th>
				<th>End date</th>
			</tr>
			</tfoot>
			<tbody>
				<?php foreach ($result as $item) : ?>
			<tr>

				<td>
					<a href="./admin.php?page=add_event&event=<?php echo $item->id; ?>"><?php echo $item->summary; ?></a>

					<div class="row-actions">
						<span class="edit"><a href="./admin.php?page=add_event&event=<?php echo $item->id; ?>"
						                      title="Edit">Edit</a> | </span><span class="trash"><a class="submitdelete"
						                                                                            title="Delete"
						                                                                            href="./admin.php?page=events&action=delete&event=<?php echo $item->id; ?>">Delete</a></span>
					</div>
				</td>
				<td><?php echo $item->url; ?></td>
				<td><?php echo $item->dtstart; ?></td>
				<td><?php echo $item->dtend; ?></td>

			</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php

	}

	function events_list_overview()
	{
		$action = $_GET['action'];

		if ($action = 'delete')
		{
			$listId = $_GET['list'];
			deleteEventList($listId);
		}

		global $wpdb;

		$table_name = $wpdb->prefix . "job_castrop_event_lists";
		$sql = "SELECT * FROM " . $table_name;

		$result = $wpdb->get_results($sql);
		?>
	<div class="wrap">
		<div id="icon-edit-comments" class="icon32"></div>
		<h2>Event lists</h2>
		<table class="widefat">
			<thead>
			<tr>
				<th>Name</th>
			</tr>
			</thead>
			<tfoot>
			<tr>
				<th>Name</th>
			</tr>
			</tfoot>
			<tbody>
				<?php foreach ($result as $item) : ?>
			<tr>
				<td>
					<a href="./admin.php?page=events&list=<?php echo $item->id; ?>"><?php echo $item->name; ?></a>

					<div class="row-actions">
						<span class="edit"><a href="./admin.php?page=add_list&list=<?php echo $item->id; ?>"
						                      title="Edit">Edit</a> | </span><span class="trash"><a class="submitdelete"
						                                                                            title="Delete"
						                                                                            href="./admin.php?page=event_lists&action=delete&list=<?php echo $item->id; ?>">Delete</a></span>
					</div>
				</td>
			</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php

	}

	function getEventLists()
	{
		global $wpdb;

		$table_name = $wpdb->prefix . "job_castrop_event_lists";
		$sql = "SELECT * FROM " . $table_name;

		$results = $wpdb->get_results($sql);

		return $results;
	}

	function deleteEventList($id)
	{
		global $wpdb;

		$table_name = $wpdb->prefix . "job_castrop_event_lists";
		$sql = "DELETE FROM " . $table_name . ' WHERE id = ' . $id;

		$results = $wpdb->get_results($sql);

		return $results;
	}

	function deleteEvent($id)
	{
		global $wpdb;

		$table_name = $wpdb->prefix . "job_castrop_events";
		$sql = "DELETE FROM " . $table_name . ' WHERE id = ' . $id;

		$results = $wpdb->get_results($sql);

		return $results;
	}

	function getEventListByName($name)
	{
		global $wpdb;

		$table_name = $wpdb->prefix . "job_castrop_event_lists";
		$sql = "SELECT * FROM " . $table_name . ' WHERE name = "' . $name . '"';

		$results = $wpdb->get_results($sql);

		return array_pop($results);
	}

	function getEventList($id)
	{
		global $wpdb;

		$table_name = $wpdb->prefix . "job_castrop_event_lists";
		$sql = "SELECT * FROM " . $table_name . ' WHERE id =' . $id;

		$results = $wpdb->get_results($sql);

		return array_pop($results);
	}

	function events_add()
	{
		global $wpdb;

		handleFormEvent();

		$id = $_GET['event'];

		$table_name = $wpdb->prefix . "job_castrop_events";
		$sql = "SELECT * FROM " . $table_name . " WHERE id = " . $id;

		$results = $wpdb->get_results($sql);
		$result = array_pop($results);

		$lists = getEventLists();

		?>
	<div class="wrap">
		<div id="icon-edit" class="icon32"></div>
		<h2>Add/Edit Event</h2>

		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>&noheader=true">
			<table class="form-table">
				<tbody>
				<tr valign="top">
					<th scope="row"><label for="summary">Title</label></th>
					<td><input id="summary" maxlength="100" size="20" type="text" name="event[summary]"
					           value="<?php echo $result->summary; ?>"/></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="url">Url</label></th>
					<td><input id="url" maxlength="100" size="20" type="text" name="event[url]"
					           value="<?php echo $result->url; ?>"/></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="buy_link">Custom field</label></th>
					<td><input id="buy_link" maxlength="100" size="20" type="text" name="event[buy_link]"
					           value="<?php echo $result->buy_link; ?>"/></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="location">Location</label></th>
					<td><input id="location" maxlength="100" size="20" type="text" name="event[location]"
					           value="<?php echo $result->location; ?>"/></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="dtstart">Date</label></th>
					<td><input id="dtstart" maxlength="100" size="20" type="text" name="event[dtstart]"
					           value="<?php echo $result->dtstart; ?>"/></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="list">List</label></th>
					<td>
						<select id="list" name="event[list]">
							<?php foreach ($lists as $list) : ?>
							<option value="<?php echo $list->id; ?>" <?php echo $list->id == $result->list
									? ' selected="true"' : ''; ?>><?php echo $list->name; ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				</tbody>
			</table>
			<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="Save event">
			</p>
		</form>
	</div>
	<?php

	}

	function events_add_list()
	{
		global $wpdb;

		handleFormEventList();

		$id = $_GET['list'];

		$table_name = $wpdb->prefix . "job_castrop_event_lists";
		$sql = "SELECT * FROM " . $table_name . " WHERE id = " . $id;

		$results = $wpdb->get_results($sql);
		$result = array_pop($results);

		?>
	<div class="wrap">
		<div id="icon-edit" class="icon32"></div>
		<h2>Add/Edit Event list</h2>

		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>&noheader=true">
			<table class="form-table">
				<tbody>
				<tr valign="top">
					<th scope="row"><label for="summary">Name</label></th>
					<td>
						<input id="summary" maxlength="100" size="20" type="text" name="list[name]"
						       value="<?php echo $result->name; ?>"/>
					</td>
				</tr>
				</tbody>
			</table>
			<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary"
			                         value="Save event list"></p>
		</form>
	</div>
	<?php

	}

	function events_settings()
	{
		handleEventSettings();

		?>
	<div id="icon-edit" class="icon32"></div>
	<h2>Settings</h2>
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>&noheader=true">
		<table class="form-table">
			<tbody>
			<tr valign="top">
				<th scope="row"><label for="date_format">Date format</label></th>
				<td>
					<input id="date_format" maxlength="100" size="20" type="text" name="settings[events_date_format]"
					       value="<?php echo get_option('events_date_format'); ?>"/>
				</td>
				<td>
					(According to the php date format <a href="http://php.net/manual/en/function.date.php">http://php.net/manual/en/function.date.php</a>)
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="date_format">Title head</label></th>
				<td>
					<input id="date_format" maxlength="100" size="20" type="text" name="settings[events_title_head]"
					       value="<?php echo get_option('events_title_head'); ?>"/>
				</td>
				<td>
					(Displayed above the title column in front-end)
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="date_format">Date head</label></th>
				<td>
					<input id="date_format" maxlength="100" size="20" type="text" name="settings[events_date_head]"
					       value="<?php echo get_option('events_date_head'); ?>"/>
				</td>
				<td>
					(Displayed above the date column in front-end)
				</td>
			</tr>
			</tbody>
		</table>
		<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="Save"></p>
	</form>
	<?php

	}

	function handleEventSettings()
	{
		if (!$_POST)
			return;

		$settings = $_POST['settings'];

		foreach ($settings as $key => $value)
		{
			update_option($key, $value);
		}

		wp_redirect('admin.php?page=events', 301);
		exit;
	}

	function handleFormEvent()
	{
		if (!$_POST)
			return;

		global $wpdb;

		$event = $_POST['event'];

		if ($_GET['event'])
			$event['id'] = $_GET['event'];

		if (!$event['dtend'])
			$event['dtend'] = $event['dtstart'];

		$table_name = $wpdb->prefix . "job_castrop_events";

		$fields = array();

		foreach ($event as $field => $value)
		{
			$fields[] = "`$field` = '$value'";
		}

		$sql = "INSERT INTO " . $table_name . " SET " . implode(', ', $fields) . " ON DUPLICATE KEY UPDATE " . implode(', ', $fields);

		$result = $wpdb->query($sql);

		wp_redirect('admin.php?page=events&list=' . $event['list'], 301);
		exit;
	}

	function handleFormEventList()
	{
		if (!$_POST)
			return;

		global $wpdb;

		$list = $_POST['list'];

		if ($_GET['list'])
			$list['id'] = $_GET['list'];

		$table_name = $wpdb->prefix . "job_castrop_event_lists";

		$fields = array();

		foreach ($list as $field => $value)
		{
			$fields[] = "`$field` = '$value'";
		}

		$sql = "INSERT INTO " . $table_name . " SET " . implode(', ', $fields) . " ON DUPLICATE KEY UPDATE " . implode(', ', $fields);

		$result = $wpdb->query($sql);

		wp_redirect('admin.php?page=events', 301);
		exit;
	}

	function events_menu()
	{
		add_object_page('Events', 'VEvents', 'manage_options', 'event_lists', 'events_list_overview');
		add_submenu_page('event_lists', 'All lists', 'All lists', 'manage_options', 'event_lists', 'events_list_overview');
		add_submenu_page('event_lists', 'All events', 'All Events', 'manage_options', 'events', 'events_overview');
		add_submenu_page('event_lists', 'Add list', 'Add list', 'manage_options', 'add_list', 'events_add_list');
		add_submenu_page('event_lists', 'Add event', 'Add event', 'manage_options', 'add_event', 'events_add');
		add_submenu_page('event_lists', 'Settings', 'Settings', 'manage_options', 'events_settings', 'events_settings');
	}

	function events_html($atts)
	{
		extract(shortcode_atts(array(
		                            'list' => '0'
		                       ), $atts));

		global $wpdb;

		$table_name = $wpdb->prefix . "job_castrop_events";
		$sql = "SELECT * FROM " . $table_name;

		if ($list)
		{
			$oList = getEventListByName($list);
			if ($oList)
				$sql .= ' WHERE list = ' . $oList->id;
		}

		$sql .= ' ORDER BY dtstart';

		$result = $wpdb->get_results($sql);

		$date_format = get_option('events_date_format');
		$title_head = get_option('events_title_head');
		$date_head = get_option('events_date_head');

		if (!$date_format)
			$date_format = 'j F Y';

		if (!$title_head)
			$title_head = 'Title';

		if (!$date_head)
			$date_head = 'Date';

		$html = '
	<table>
		<thead>
		<th>' . $title_head . '</th>
		<th colspan="2">' . $date_head . '<th>
		</thead>
		<tbody>';

		foreach ($result as $item) :

			if (isValidDateTime($item->dtstart))
			{
				$time = strtotime($item->dtstart);
				$display = date_i18n($date_format, $time);
				$iso = date('Y-m-d', $time);
			}
			else
			{
				$display = $item->dtstart;
				$iso = '';
			}

			$html .= '<tr class="';

			if ($iso):
				$html .= 'vevent ';
			endif;

			$html .= 'job_castrop_event"><td width="450">';

			if ($item->url) :
				$html .= '<a class="url summary" href="' . $item->url . '">' . $item->summary . '</a>';
			else :
				$html .= $item->summary;
			endif;

			$html .= '</td><td width="150">' . $display;
			if ($iso):
				$html .= '<span class="dtstart" style="display: none;">' . $iso . '</span>';
			endif;

			$html .= '<span class="location" style="display: none;">' . $item->location . '</span>
				</td>
				<td>
					' . $item->buy_link . '
				</td>
			</tr>';

		endforeach;
		$html .= '</tbody></table>';

		return $html;
	}

function events_html_list($atts)
{
    extract(shortcode_atts(array(
        'list' => '0'
    ), $atts));

    global $wpdb;

    $table_name = $wpdb->prefix . "job_castrop_events";
    $sql = "SELECT * FROM " . $table_name;

    if ($list)
    {
        $oList = getEventListByName($list);
        if ($oList)
            $sql .= ' WHERE list = ' . $oList->id;
    }

    $sql .= ' ORDER BY dtstart';

    $result = $wpdb->get_results($sql);

    $date_format = get_option('events_date_format');
    $title_head = get_option('events_title_head');
    $date_head = get_option('events_date_head');

    if (!$date_format)
        $date_format = 'j F Y';

    if (!$title_head)
        $title_head = 'Title';

    if (!$date_head)
        $date_head = 'Date';

    $html = '<ul>';

    foreach ($result as $item) :

        if (isValidDateTime($item->dtstart))
        {
            $time = strtotime($item->dtstart);
            $display = date_i18n($date_format, $time);
            $iso = date('Y-m-d', $time);
        }
        else
        {
            $display = $item->dtstart;
            $iso = '';
        }

        $html .= '<li class="';

        if ($iso):
            $html .= 'vevent ';
        endif;

        $html .= 'job_castrop_event">';

        if($display)
            $display .=  ', ' . $item->summary;
        else
            $display =  $item->summary;

        if ($item->url) :
            $html .= '<a class="url summary" href="' . $item->url . '">' .  $display . '</a>';
        else :
            $html .= $display;
        endif;

        if ($iso):
            $html .= '<span class="dtstart" style="display: none;">' . $iso . '</span>';
        endif;

        $html .= '<span class="location" style="display: none;">' . $item->location . '</span> ' . $item->buy_link . '</li>';

    endforeach;
    $html .= '</ul>';

    return $html;
}

	function isValidDateTime($dateTime)
	{
		if (preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $dateTime, $matches))
		{
			if (checkdate($matches[2], $matches[3], $matches[1]))
			{
				return true;
			}
		}

		return false;
	}

	function events_widget($args)
	{
		extract($args);

		$options = get_option("events_widget_options");
		if (!is_array($options))
		{
			$options = array(
				'title' => 'Upcomming events',
				'number' => 5,
				'list' => 0
			);
		}

		echo $before_widget;
		echo $before_title . $options['title'] . $after_title;

		global $wpdb;

		$table_name = $wpdb->prefix . "job_castrop_events";
		$sql = "SELECT * FROM " . $table_name;

		if ($options['list'])
		{
			$sql .= ' WHERE list = ' . $options['list'];
		}

		$sql .= ' ORDER BY dtstart';

		$result = $wpdb->get_results($sql);

		$date_format = get_option('events_date_format');
		?>
	<ul>
		<?php $count = 0; foreach ($result as $item) :

		if (isValidDateTime($item->dtstart))
		{
			$time = strtotime($item->dtstart);
			$display = date_i18n($date_format, $time);
			$iso = date('Y-m-d', $time);
		}
		else
		{
			$display = $item->dtstart;
			$iso = '';
		}


		?>
		<li class="<?php if ($iso): ?>vevent <?php endif; ?>job_castrop_event">
			<?php if ($item->url) : ?>
			<a class="url summary" href="<?php echo $item->url; ?>"><?php echo $item->summary; ?></a>
			<?php else : ?>
			<?php echo $item->summary; ?>
			<?php endif; ?>
			<?php if ($display): ?>
			&nbsp;(<?php echo $display; ?>)<?php if ($iso): ?>
				<span class="dtstart" style="display: none;"><?php echo $iso; ?><?php endif; ?></span>
			<span class="location" style="display: none;"><?php echo $item->location; ?></span>
			<?php endif; ?>
		</li>
		<?php $count++;
		if ($count >= $options['number'])
		{
			break;
		} endforeach; ?>
	</ul>
	<?php
		echo $after_widget;
	}

	function events_init()
	{
		register_sidebar_widget(__('Events Widget'), 'events_widget');
		register_widget_control('Events Widget', 'event_widget_control', 300, 200);
	}

	function event_widget_control()
	{
		$lists = getEventLists();

		$options = get_option("events_widget_options");
		if (!is_array($options))
		{
			$options = array(
				'title' => 'Upcomming events',
				'number' => 5,
				'list' => 0
			);
		}

		if ($_POST['event-widget-submit'])
		{
			$options['title'] = htmlspecialchars($_POST['event-widget-title']);
			$options['number'] = is_numeric($_POST['event-widget-number']) ? $_POST['event-widget-number'] : 5;
			$options['list'] = $_POST['event-widget-list'];
			update_option("events_widget_options", $options);
		}

		?>
	<p>
		<label for="event-widget-title">Widget Title: </label>
		<br/>
		<input type="text" id="event-widget-title" name="event-widget-title" value="<?php echo $options['title'];?>"/>
		<br/>
		<label for="event-widget-number">Number of events: </label>
		<br/>
		<input type="text" id="event-widget-number" name="event-widget-number"
		       value="<?php echo $options['number'];?>"/>
		<br/>
		<label for="event-widget-list">Event list: </label>
		<br/>
		<select id="event-widget-list" name="event-widget-list">
			<option value="0">-- All events --</option>
			<?php foreach ($lists as $list) : ?>
			<option value="<?php echo $list->id; ?>" <?php echo $list->id == $options['list']
					? ' selected="true"' : ''; ?>><?php echo $list->name; ?></option>
			<?php endforeach; ?>

		</select>
		<input type="hidden" id="event-widget-submit" name="event-widget-submit" value="1"/>
	</p>
	<?php

	}

	add_action('admin_menu', 'events_menu');
	add_action("plugins_loaded", "events_init");
	register_activation_hook(__FILE__, 'events_install');
	add_shortcode('vevents', 'events_html');
	add_shortcode('vevents_list', 'events_html_list');
?>