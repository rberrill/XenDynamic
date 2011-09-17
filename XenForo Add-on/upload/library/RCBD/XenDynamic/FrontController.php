<?php
/*
 * The code to attach to the Xenforo database was inspired and used with permission by
 * Darkimmortal of the Xenforo community: http://xenforo.com/community/members/darkimmortal.215/http://xenforo.com/community/members/darkimmortal.215/
*/
class RCBD_XenDynamic_FrontController extends XenForo_FrontController
{
	public function runXenDynamic($html)
	{
		global $XenDynamic_indexFile, $XenDynamic_container;
		
		ob_start();

		$this->setup();
		$this->_request->setBasePath(XenForo_Link::convertUriToAbsoluteUri("{$XenDynamic_indexFile}"));
		$this->setRequestPaths();
		$showDebugOutput = $this->showDebugOutput();

		$this->_dependencies->preLoadData();

		XenForo_CodeEvent::fire('front_controller_pre_route', array($this));
		$routeMatch = $this->route();

		XenForo_CodeEvent::fire('front_controller_pre_dispatch', array($this, &$routeMatch));

		$controllerResponse = $this->dispatch($routeMatch);
		$controllerResponse = new XenForo_ControllerResponse_View();
		$controllerResponse->templateName = "XenDynamic";
		$controllerResponse->viewName = "XenDynamic_Index";
/*
		$title = "";
		if(preg_match('/<title>(.*?)<\/title>/i', $html, $matches) && count($matches) == 2){
			$title = $matches[1];
		}
		$controllerResponse->params = array(
			'title' => $title,
			'html' => $html
		);                
*/
		$viewRenderer = $this->_getViewRenderer('html');
		if (!$viewRenderer)
		{
			XenForo_Error::noViewRenderer($this->_request);
			exit;
		}
		$viewRenderer->setNeedsContainer($XenDynamic_container);
		$containerParams = array();
		
		XenForo_CodeEvent::fire('front_controller_pre_view',
			array($this, &$controllerResponse, &$viewRenderer, &$containerParams)
		);

		$content = $this->renderView($controllerResponse, $viewRenderer, $containerParams);

		if ($showDebugOutput)
		{
			$content = $this->renderDebugOutput($content);
		}

		$bufferedContents = ob_get_contents();
		ob_end_clean();
		if ($bufferedContents !== '')
		{
			$content = $bufferedContents . $content;
		}

		XenForo_CodeEvent::fire('front_controller_post_view', array($this, &$content));
/*
		if ($this->_sendResponse)
		{
			$headers = $this->_response->getHeaders();
			$isText = false;
			foreach ($headers AS $header)
			{
				if ($header['name'] == 'Content-Type')
				{
					if (strpos($header['value'], 'text/') === 0)
					{
						$isText = true;
					}
					break;
				}
			}
			if ($isText && is_string($content) && $content)
			{
				$extraHeaders = XenForo_Application::gzipContentIfSupported($content);
				foreach ($extraHeaders AS $extraHeader)
				{
					$this->_response->setHeader($extraHeader[0], $extraHeader[1], $extraHeader[2]);
				}
			}

			if (is_string($content) && $content && !ob_get_level() && XenForo_Application::get('config')->enableContentLength)
			{
				$this->_response->setHeader('Content-Length', strlen($content), true);
			}

			$this->_response->sendHeaders();

			if ($content instanceof XenForo_FileOutput)
			{
				$content->output();
			}
			else
			{
				echo $content;
			}
		}
		else
		{
 */
			return $content;
// 		}
	}
}
