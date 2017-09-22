<?php
/**
 * UniverseApi
 * PHP version 5
 *
 * @category Class
 * @package  Swagger\Client
 * @author   http://github.com/swagger-api/swagger-codegen
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * 
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Swagger\Client\ContentEntity\Api;

use \Swagger\Client\Configuration;
use \Swagger\Client\ApiClient;
use \Swagger\Client\ApiException;
use \Swagger\Client\ObjectSerializer;

/**
 * UniverseApi Class Doc Comment
 *
 * @category Class
 * @package  Swagger\Client
 * @author   http://github.com/swagger-api/swagger-codegen
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class UniverseApi
{

    /**
     * API Client
     *
     * @var \Swagger\Client\ApiClient instance of the ApiClient
     */
    protected $apiClient;

    /**
     * Constructor
     *
     * @param \Swagger\Client\ApiClient|null $apiClient The api client to use
     */
    public function __construct(\Swagger\Client\ApiClient $apiClient = null)
    {
        if ($apiClient == null) {
            $apiClient = new ApiClient();
            $apiClient->getConfig()->setHost('https://localhost/content-entity-service');
        }

        $this->apiClient = $apiClient;
    }

    /**
     * Get API client
     *
     * @return \Swagger\Client\ApiClient get the API client
     */
    public function getApiClient()
    {
        return $this->apiClient;
    }

    /**
     * Set the API client
     *
     * @param \Swagger\Client\ApiClient $apiClient set the API client
     *
     * @return UniverseApi
     */
    public function setApiClient(\Swagger\Client\ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
        return $this;
    }

    /**
     * Operation create
     *
     * creates a new universe
     *
     * @param string $name  (optional)
     * @param string $language  (optional)
     * @return \Swagger\Client\ContentEntity\Models\Universe
     * @throws \Swagger\Client\ApiException on non-2xx response
     */
    public function create($name = null, $language = null)
    {
        list($response) = $this->createWithHttpInfo($name, $language);
        return $response;
    }

    /**
     * Operation createWithHttpInfo
     *
     * creates a new universe
     *
     * @param string $name  (optional)
     * @param string $language  (optional)
     * @return Array of \Swagger\Client\ContentEntity\Models\Universe, HTTP status code, HTTP response headers (array of strings)
     * @throws \Swagger\Client\ApiException on non-2xx response
     */
    public function createWithHttpInfo($name = null, $language = null)
    {
        // parse inputs
        $resourcePath = "/universe";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/x-www-form-urlencoded'));

        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // form params
        if ($name !== null) {
            $formParams['name'] = $this->apiClient->getSerializer()->toFormValue($name);
        }
        // form params
        if ($language !== null) {
            $formParams['language'] = $this->apiClient->getSerializer()->toFormValue($language);
        }
        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires API key authentication
        $apiKey = $this->apiClient->getApiKeyWithPrefix('AUTH-SECRET');
        if (strlen($apiKey) !== 0) {
            $headerParams['AUTH-SECRET'] = $apiKey;
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\Swagger\Client\ContentEntity\Models\Universe',
                '/universe'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\Swagger\Client\ContentEntity\Models\Universe', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\Swagger\Client\ContentEntity\Models\Universe', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation delete
     *
     * deletes an universe
     *
     * @param string $universe_id  (required)
     * @return void
     * @throws \Swagger\Client\ApiException on non-2xx response
     */
    public function delete($universe_id)
    {
        list($response) = $this->deleteWithHttpInfo($universe_id);
        return $response;
    }

    /**
     * Operation deleteWithHttpInfo
     *
     * deletes an universe
     *
     * @param string $universe_id  (required)
     * @return Array of null, HTTP status code, HTTP response headers (array of strings)
     * @throws \Swagger\Client\ApiException on non-2xx response
     */
    public function deleteWithHttpInfo($universe_id)
    {
        // verify the required parameter 'universe_id' is set
        if ($universe_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $universe_id when calling delete');
        }
        // parse inputs
        $resourcePath = "/universe/{universeId}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array());

        // path params
        if ($universe_id !== null) {
            $resourcePath = str_replace(
                "{" . "universeId" . "}",
                $this->apiClient->getSerializer()->toPathValue($universe_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires API key authentication
        $apiKey = $this->apiClient->getApiKeyWithPrefix('AUTH-SECRET');
        if (strlen($apiKey) !== 0) {
            $headerParams['AUTH-SECRET'] = $apiKey;
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'DELETE',
                $queryParams,
                $httpBody,
                $headerParams,
                null,
                '/universe/{universeId}'
            );

            return array(null, $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\Swagger\Client\ContentEntity\Models\ResponseObj', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\Swagger\Client\ContentEntity\Models\ResponseObj', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation getById
     *
     * gets an universe by its id
     *
     * @param string $universe_id  (required)
     * @return \Swagger\Client\ContentEntity\Models\Universe
     * @throws \Swagger\Client\ApiException on non-2xx response
     */
    public function getById($universe_id)
    {
        list($response) = $this->getByIdWithHttpInfo($universe_id);
        return $response;
    }

    /**
     * Operation getByIdWithHttpInfo
     *
     * gets an universe by its id
     *
     * @param string $universe_id  (required)
     * @return Array of \Swagger\Client\ContentEntity\Models\Universe, HTTP status code, HTTP response headers (array of strings)
     * @throws \Swagger\Client\ApiException on non-2xx response
     */
    public function getByIdWithHttpInfo($universe_id)
    {
        // verify the required parameter 'universe_id' is set
        if ($universe_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $universe_id when calling getById');
        }
        // parse inputs
        $resourcePath = "/universe/{universeId}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array());

        // path params
        if ($universe_id !== null) {
            $resourcePath = str_replace(
                "{" . "universeId" . "}",
                $this->apiClient->getSerializer()->toPathValue($universe_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\Swagger\Client\ContentEntity\Models\Universe',
                '/universe/{universeId}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\Swagger\Client\ContentEntity\Models\Universe', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\Swagger\Client\ContentEntity\Models\Universe', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\Swagger\Client\ContentEntity\Models\ResponseObj', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\Swagger\Client\ContentEntity\Models\ResponseObj', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation update
     *
     * updates an universe
     *
     * @param string $universe_id  (required)
     * @param string $name  (optional)
     * @param string $language  (optional)
     * @return void
     * @throws \Swagger\Client\ApiException on non-2xx response
     */
    public function update($universe_id, $name = null, $language = null)
    {
        list($response) = $this->updateWithHttpInfo($universe_id, $name, $language);
        return $response;
    }

    /**
     * Operation updateWithHttpInfo
     *
     * updates an universe
     *
     * @param string $universe_id  (required)
     * @param string $name  (optional)
     * @param string $language  (optional)
     * @return Array of null, HTTP status code, HTTP response headers (array of strings)
     * @throws \Swagger\Client\ApiException on non-2xx response
     */
    public function updateWithHttpInfo($universe_id, $name = null, $language = null)
    {
        // verify the required parameter 'universe_id' is set
        if ($universe_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $universe_id when calling update');
        }
        // parse inputs
        $resourcePath = "/universe/{universeId}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array());

        // path params
        if ($universe_id !== null) {
            $resourcePath = str_replace(
                "{" . "universeId" . "}",
                $this->apiClient->getSerializer()->toPathValue($universe_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // form params
        if ($name !== null) {
            $formParams['name'] = $this->apiClient->getSerializer()->toFormValue($name);
        }
        // form params
        if ($language !== null) {
            $formParams['language'] = $this->apiClient->getSerializer()->toFormValue($language);
        }
        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires API key authentication
        $apiKey = $this->apiClient->getApiKeyWithPrefix('AUTH-SECRET');
        if (strlen($apiKey) !== 0) {
            $headerParams['AUTH-SECRET'] = $apiKey;
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                null,
                '/universe/{universeId}'
            );

            return array(null, $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\Swagger\Client\ContentEntity\Models\ResponseObj', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\Swagger\Client\ContentEntity\Models\ResponseObj', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

}
