<?php

namespace Ecs\L8Core\Aws;

use Aws\Exception\AwsException;
use Aws\Ses\SesClient;
use Ecs\L8Core\Core\BaseService;
use Illuminate\Http\Response;

class SesMailTemplateService extends BaseService
{
    /** @var SesClient $ses */
    protected $ses = null;

    /** @var mixed $result */
    protected $result = null;

    /** @var int $limit */
    protected $limit = 100;

    /** @var array $configurationSet */
    protected $configurationSet = [];

    /**
     * SesMailTemplateService constructor.
     */
    public function __construct()
    {
        $hasCredentials = config('services.ses.has_credentials');
        $config         = [
            'version' => 'latest',
            'region'  => config('services.ses.region')
        ];

        if ($hasCredentials) {
            $config['credentials'] = [
                'key'    => config('services.ses.key'),
                'secret' => config('services.ses.secret'),
            ];
        }

        $this->ses = new SesClient($config);
    }

    /**
     * Logic to handle the data
     */
    public function handle()
    {
        //
    }

    /**
     * Get list mail templates
     *
     * @return array|mixed
     */
    public function getListMailTemplate()
    {
        try {
            $this->result = $this->ses->listTemplates([
                'MaxItems' => $this->limit
            ])->toArray();

            return $this->result['TemplatesMetadata'];
        } catch (AwsException $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Get detail a mail template
     *
     * @param string $name
     * @return array
     */
    public function getMailTemplate(string $name)
    {
        try {
            $this->result = $this->ses->getTemplate([
                'TemplateName' => $name
            ])->toArray();

            return $this->result['Template'];
        } catch (AwsException $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Send mail template
     *
     * @param string $template
     * @param string $sender
     * @param array $receivers
     * @param array $data
     * @param array $bccAddresses
     * @return array
     */
    public function sendTemplatedEmail(
        string $template,
        string $sender,
        array $receivers,
        array $data,
        array $bccAddresses= []
    ) {
        try {
            $this->result = $this->ses->sendTemplatedEmail([
                'Source'       => $sender,
                'Template'     => $template,
                'TemplateData' => json_encode($data),
                'Destination'  => [
                    'ToAddresses' => $receivers,
                    'BccAddresses' => $bccAddresses
                ]
            ])->toArray();

            return $this->getResponse();
        } catch (AwsException $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Send Bulk Templated Email
     *
     * @param string $template
     * @param string $sender
     * @param array $receivers
     * @param array $data
     * @return array
     */
    public function sendBulkTemplatedEmail(string $template, string $sender, array $receivers, array $data)
    {
        try {
            if (empty($receivers)) {
                return ['status' => false, 'message' => 'None'];
            }

            $destinations = [];

            collect($receivers)->each(function ($receiver) use ($data, &$destinations) {
                $destinations[] = [
                    'Destination' => [
                        'ToAddresses' => [$receiver],
                    ],
                    'ReplacementTemplateData' => json_encode($data)
                ];
            });

            $this->result = $this->ses->sendBulkTemplatedEmail(array_merge([
                'Source'              => $sender,
                'Template'            => $template,
                'DefaultTemplateData' => json_encode($data),
                'Destinations'        => $destinations
            ], $this->configurationSet))->toArray();

            return $this->getResponse();
        } catch (AwsException $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Create Mail Template on SES
     *
     * @param string $templateName
     * @param string $subject
     * @param string $htmlBody
     * @param string $plaintext
     * @return mixed
     */
    public function createMailTemplate(string $templateName, string $subject, string $htmlBody, string $plaintext = '')
    {
        try {
            $this->result = $this->ses->createTemplate([
                'Template' => [
                    'HtmlPart'     => $htmlBody,
                    'SubjectPart'  => $subject,
                    'TemplateName' => $templateName,
                    'TextPart'     => $plaintext,
                ],
            ])->toArray();

            return $this->getResponse();
        } catch (AwsException $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Setup response
     *
     * @return array
     */
    protected function getResponse()
    {
        return ($this->result['@metadata']['statusCode'] == Response::HTTP_OK)
            ? ['status' => true, 'message' => 'Send mail succeed']
            : ['status' => false, 'message' => 'Send mail failed'];
    }

    /**
     * Set limit for listing
     *
     * @param int $limit
     * @return $this
     */
    protected function setLimit(int $limit)
    {
        $this->limit = $limit;

        return $this;
    }

    public function setConfigurationSet(string $config)
    {
        $this->configurationSet = ['ConfigurationSetName' => $config];

        return $this;
    }
}
