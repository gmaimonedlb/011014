<?php
class ControllerReportProductPurchasedPercent extends Controller {
        public function index()
        {
            $this->language->load('report/product_purchased_percent');
            $this->document->setTitle($this->language->get('heading_title'));
            $this->load->model('report/percent');
            $results = $this->model_report_percent->getManufacturer();

            $this->data['breadcrumbs'] = array();

            $this->data['breadcrumbs'][] = array(
                'text'      => $this->language->get('text_home'),
                'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
                'separator' => false
            );

            foreach ($results as $result) {
                $this->data['manufacturers'][] = array(
                    'manufacturer_id'       => $result['manufacturer_id'],
                    'name'      => $result['name'],
                    'percent'   => $result['percent']
                );

            }

////////////////////////////////////////////////////////////////////////////////////////////////////
            $this->data['heading_title'] = $this->language->get('heading_title_manufacturer');

            $this->data['text_no_results'] = $this->language->get('text_no_results');
            $this->data['text_all_status'] = $this->language->get('text_all_status');

            $this->data['column_manufacturer'] = $this->language->get('column_manufacturer');
            $this->data['column_name'] = $this->language->get('column_name');
            $this->data['column_foundation'] = $this->language->get('column_foundation');
            $this->data['column_model'] = $this->language->get('column_model');
            $this->data['column_price'] = $this->language->get('column_price');
            $this->data['column_date'] = $this->language->get('column_date');
            $this->data['token'] = $this->session->data['token'];
            $this->template = 'report/manufacturers.tpl';
            $this->children = array(
                'common/header',
                'common/footer'
            );

            $this->response->setOutput($this->render());
/////////////////////////////////////////////////////////////////////////////////////////////77777
        }

        public function foundation() {
		$this->language->load('report/product_purchased_percent');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = '';
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = '';
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$filter_order_status_id = $this->request->get['filter_order_status_id'];
		} else {
			$filter_order_status_id = 0;
		}	

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

        if (isset($this->request->get['id_found'])) {
            $id_found = $this->request->get['id_found'];
        } else {
            $id_found = '';
        }

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }
        if (isset($this->request->get['id_found'])) {
            $url .= '&id_found=' . $this->request->get['id_found'];
        }


		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('report/product_purchased_percent/foundation', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->load->model('report/percent');

		$this->data['products'] = array();

		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end,
            'filter_order_status_id' => $filter_order_status_id,
            'id_found' => $id_found,
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);

		$product_total = $this->model_report_percent->getTotalPurchased($data);

        $results = $this->model_report_percent->getPurchased($data);
        $total_foundation=0;
		foreach ($results as $result) {
			$this->data['products'][] = array(
				'order_id'       => $result['order_id'],
				'name'      => $result['name'],
                'price'   => round($result['price'],2),
                'model'   => $result['model'],
                'fecha'   => $result['fecha'],
				'foundation'      => str_replace("$", "", $result['price'])* ($result['percentage']/100),
                'manufacturer'   => $result['manufacturer'],
                'percentage'   => $result['percentage'],

            );
            $total_foundation+=str_replace("$", "", $result['price'])* ($result['percentage']/100);
		}
        $this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_all_status'] = $this->language->get('text_all_status');

        $this->data['column_manufacturer'] = $this->language->get('column_manufacturer');
        $this->data['column_name'] = $this->language->get('column_name');
        $this->data['column_foundation'] = $this->language->get('column_foundation');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_date'] = $this->language->get('column_date');

		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->data['entry_status'] = $this->language->get('entry_status');

		$this->data['button_filter'] = $this->language->get('button_filter');

		$this->data['token'] = $this->session->data['token'];

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}
        if (isset($this->request->get['id_found'])) {
            $url .= '&id_found=' . $this->request->get['id_found'];
        }

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/product_purchased_percent/fundation', 'token=' . $this->session->data['token'] . $url . '&page={page}');

		$this->data['pagination'] = $pagination->render();		

		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;
        $this->data['filter_order_status_id'] = $filter_order_status_id;
        $this->data['id_found'] = $id_found;
        $this->data['total_foundation'] = $total_foundation;

		$this->template = 'report/product_purchased_percent.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
    public function email()
    {
        $this->language->load('report/product_purchased_percent');

        $this->document->setTitle($this->language->get('heading_title'));

        if (isset($this->request->get['filter_date_start'])) {
            $filter_date_start = $this->request->get['filter_date_start'];
        } else {
            $filter_date_start = '';
        }

        if (isset($this->request->get['filter_date_end'])) {
            $filter_date_end = $this->request->get['filter_date_end'];
        } else {
            $filter_date_end = '';
        }

        if (isset($this->request->get['filter_order_status_id'])) {
            $filter_order_status_id = $this->request->get['filter_order_status_id'];
        } else {
            $filter_order_status_id = 0;
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        if (isset($this->request->get['id_found'])) {
            $id_found = $this->request->get['id_found'];
        } else {
            $id_found = '';
        }

        $url = '';

        if (isset($this->request->get['filter_date_start'])) {
            $url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
        }

        if (isset($this->request->get['filter_date_end'])) {
            $url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
        }

        if (isset($this->request->get['filter_order_status_id'])) {
            $url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }
        if (isset($this->request->get['id_found'])) {
            $url .= '&id_found=' . $this->request->get['id_found'];
        }


        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('report/product_purchased_percent/email', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        $this->load->model('report/percent');

        $this->data['products'] = array();

        $data = array(
            'filter_date_start'	     => $filter_date_start,
            'filter_date_end'	     => $filter_date_end,
            'filter_order_status_id' => $filter_order_status_id,
            'id_found' => $id_found,
            'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit'                  => $this->config->get('config_admin_limit')
        );

        $product_total = $this->model_report_percent->getTotalPurchased($data);

        $results = $this->model_report_percent->getPurchased($data);
        $total_foundation=0;
        foreach ($results as $result) {
            $this->data['products'][] = array(
                'order_id'       => $result['order_id'],
                'name'      => $result['name'],
                'price'   => round($result['price'],2),
                'model'   => $result['model'],
                'fecha'   => $result['fecha'],
                'foundation'      => str_replace("$", "", $result['price'])*  ($result['percentage']/100),
                'manufacturer'   => $result['manufacturer'],

            );
            $total_foundation+=str_replace("$", "", $result['price'])*  ($result['percentage']/100);

        }

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_no_results'] = $this->language->get('text_no_results');
        $this->data['text_all_status'] = $this->language->get('text_all_status');

        $this->data['column_manufacturer'] = $this->language->get('column_manufacturer');
        $this->data['column_name'] = $this->language->get('column_name');
        $this->data['column_foundation'] = $this->language->get('column_foundation');
        $this->data['column_model'] = $this->language->get('column_model');
        $this->data['column_price'] = $this->language->get('column_price');
        $this->data['column_date'] = $this->language->get('column_date');

        $this->data['entry_date_start'] = $this->language->get('entry_date_start');
        $this->data['entry_date_end'] = $this->language->get('entry_date_end');
        $this->data['entry_status'] = $this->language->get('entry_status');

        $this->data['button_filter'] = $this->language->get('button_filter');

        $this->data['token'] = $this->session->data['token'];

        $this->load->model('localisation/order_status');

        $this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $url = '';

        if (isset($this->request->get['filter_date_start'])) {
            $url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
        }

        if (isset($this->request->get['filter_date_end'])) {
            $url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
        }

        if (isset($this->request->get['filter_order_status_id'])) {
            $url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
        }
        if (isset($this->request->get['id_found'])) {
            $url .= '&id_found=' . $this->request->get['id_found'];
        }

        $pagination = new Pagination();
        $pagination->total = $product_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('report/product_purchased_percent/email', 'token=' . $this->session->data['token'] . $url . '&page={page}');

        $this->data['pagination'] = $pagination->render();

        $this->data['filter_date_start'] = $filter_date_start;
        $this->data['filter_date_end'] = $filter_date_end;
        $this->data['filter_order_status_id'] = $filter_order_status_id;
        $this->data['id_found'] = $id_found;

       /* $this->template = 'mail/percent.tpl';


        $this->response->setOutput($this->render());*/
        ?>

        <link rel="stylesheet" type="text/css" href="view/stylesheet/stylesheet.css" />
        <meta charset="UTF-8" />

        <div id="content">
            <div > <!--class="box"-->
                <div class="heading">
                    <h1><!--img src="view/image/report.png" alt="" /--> <?php echo "Report"; ?></h1>
                </div>
                <div class="content">
                    <table class="list">
                        <thead>
                        <tr>
                            <td class="left"><?php echo "Manufacturer"; ?></td>
                            <td class="left"><?php echo "Name"; ?></td>
                            <td class="right"><?php echo "Price"; ?></td>
                            <td class="right"><?php echo "Model"; ?></td>
                            <td class="right"><?php echo "Date"; ?></td>
                            <td class="right"><?php echo "Foundation"; ?></td>
                        </tr>
                        </thead>
                        <tbody>

                        <?php  if ($this->data['products']) { ?>
                            <?php foreach ($this->data['products'] as $product) { ?>
                                <tr>
                                    <td class="left"><?php echo $product['manufacturer']; ?></td>
                                    <td class="left"><?php echo $product['name']; ?></td>
                                    <td class="right"><?php echo $product['price']; ?></td>
                                    <td class="right"><?php echo $product['model']; ?></td>
                                    <td class="right"><?php echo $product['fecha']; ?></td>
                                    <td class="right"><?php echo $product['foundation']; ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td class="left"></td>
                                <td class="left"></td>
                                <td class="right"></td>
                                <td class="right"></td>
                                <td class="right"></td>
                                <td class="right"><b>Total $ <?php echo $total_foundation; ?></b></td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<?php
mail("gmaimone21@gmail.com","prueba","hola mundo");
    }
}
?>