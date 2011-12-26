<?php
require_once APPPATH . 'third_party/amqp/amqp.inc';

class Mq extends CI_Model {

	function publish($msgobj, $queue, $vhost='/') { //{{{
		$exchange = '';
		$conn = new AMQPConnection(
				$this->config->item('mq_host'),
				$this->config->item('mq_port'),
				$this->config->item('mq_user'),
				$this->config->item('mq_pass'),
				$vhost
				);
		$ch = $conn->channel();

		/*
			name: $queue
			passive: false
			durable: true // the queue will survive server restarts
			exclusive: false // the queue can be accessed in other channels
			auto_delete: false //the queue won't be deleted once the channel is closed.
		 */
		$ch->queue_declare($queue, false, true, false, false);

		$msg_body = json_encode($msgobj);
		$msg = new AMQPMessage($msg_body, array(
					'content_type' => 'text/plain',
					'delivery_mode' => 2, # persistent msg
					));
		$ch->basic_publish($msg, $exchange, $queue);

		$ch->close();
		$conn->close();
	} //}}}
}
