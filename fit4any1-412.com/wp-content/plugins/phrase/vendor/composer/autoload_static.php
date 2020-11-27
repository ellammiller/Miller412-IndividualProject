<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfc8574130448d00b66871ae3dac6b736
{
    public static $files = array (
        '7b11c4dc42b3b3023073cb14e519683c' => __DIR__ . '/..' . '/ralouphie/getallheaders/src/getallheaders.php',
        '25072dd6e2470089de65ae7bf11d3109' => __DIR__ . '/..' . '/symfony/polyfill-php72/bootstrap.php',
        'e69f7f6ee287b969198c3c9d6777bd38' => __DIR__ . '/..' . '/symfony/polyfill-intl-normalizer/bootstrap.php',
        'c964ee0ededf28c96ebd9db5099ef910' => __DIR__ . '/..' . '/guzzlehttp/promises/src/functions_include.php',
        'a0edc8309cc5e1d60e3047b5df6b7052' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/functions_include.php',
        'f598d06aa772fa33d905e87be6398fb1' => __DIR__ . '/..' . '/symfony/polyfill-intl-idn/bootstrap.php',
        '37a3dc5111fe8f707ab4c132ef1dbc62' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/functions_include.php',
        'dd61a1fbb72001663ba08971c6847c5c' => __DIR__ . '/../..' . '/inc/namespace.php',
        '7a1804d849d1be5bbe281757df6a16ea' => __DIR__ . '/../..' . '/inc/connections.php',
        'edbf23d8ab2beabfa153f97866433829' => __DIR__ . '/../..' . '/inc/Admin/namespace.php',
        'e2ad3c33e8b9e58c86014f894129e5a8' => __DIR__ . '/../..' . '/inc/RestAPI/namespace.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Php72\\' => 23,
            'Symfony\\Polyfill\\Intl\\Normalizer\\' => 33,
            'Symfony\\Polyfill\\Intl\\Idn\\' => 26,
        ),
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
            'Phrase\\WP\\' => 10,
            'Phrase\\' => 7,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Psr7\\' => 16,
            'GuzzleHttp\\Promise\\' => 19,
            'GuzzleHttp\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Php72\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-php72',
        ),
        'Symfony\\Polyfill\\Intl\\Normalizer\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-intl-normalizer',
        ),
        'Symfony\\Polyfill\\Intl\\Idn\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-intl-idn',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Phrase\\WP\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc',
        ),
        'Phrase\\' => 
        array (
            0 => __DIR__ . '/..' . '/phrase/phrase-php/lib',
        ),
        'GuzzleHttp\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
        ),
        'GuzzleHttp\\Promise\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/promises/src',
        ),
        'GuzzleHttp\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/guzzle/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'GuzzleHttp\\Client' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Client.php',
        'GuzzleHttp\\ClientInterface' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/ClientInterface.php',
        'GuzzleHttp\\Cookie\\CookieJar' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Cookie/CookieJar.php',
        'GuzzleHttp\\Cookie\\CookieJarInterface' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Cookie/CookieJarInterface.php',
        'GuzzleHttp\\Cookie\\FileCookieJar' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Cookie/FileCookieJar.php',
        'GuzzleHttp\\Cookie\\SessionCookieJar' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Cookie/SessionCookieJar.php',
        'GuzzleHttp\\Cookie\\SetCookie' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Cookie/SetCookie.php',
        'GuzzleHttp\\Exception\\BadResponseException' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Exception/BadResponseException.php',
        'GuzzleHttp\\Exception\\ClientException' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Exception/ClientException.php',
        'GuzzleHttp\\Exception\\ConnectException' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Exception/ConnectException.php',
        'GuzzleHttp\\Exception\\GuzzleException' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Exception/GuzzleException.php',
        'GuzzleHttp\\Exception\\InvalidArgumentException' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Exception/InvalidArgumentException.php',
        'GuzzleHttp\\Exception\\RequestException' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Exception/RequestException.php',
        'GuzzleHttp\\Exception\\SeekException' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Exception/SeekException.php',
        'GuzzleHttp\\Exception\\ServerException' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Exception/ServerException.php',
        'GuzzleHttp\\Exception\\TooManyRedirectsException' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Exception/TooManyRedirectsException.php',
        'GuzzleHttp\\Exception\\TransferException' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Exception/TransferException.php',
        'GuzzleHttp\\HandlerStack' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/HandlerStack.php',
        'GuzzleHttp\\Handler\\CurlFactory' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Handler/CurlFactory.php',
        'GuzzleHttp\\Handler\\CurlFactoryInterface' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Handler/CurlFactoryInterface.php',
        'GuzzleHttp\\Handler\\CurlHandler' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Handler/CurlHandler.php',
        'GuzzleHttp\\Handler\\CurlMultiHandler' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Handler/CurlMultiHandler.php',
        'GuzzleHttp\\Handler\\EasyHandle' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Handler/EasyHandle.php',
        'GuzzleHttp\\Handler\\MockHandler' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Handler/MockHandler.php',
        'GuzzleHttp\\Handler\\Proxy' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Handler/Proxy.php',
        'GuzzleHttp\\Handler\\StreamHandler' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Handler/StreamHandler.php',
        'GuzzleHttp\\MessageFormatter' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/MessageFormatter.php',
        'GuzzleHttp\\Middleware' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Middleware.php',
        'GuzzleHttp\\Pool' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Pool.php',
        'GuzzleHttp\\PrepareBodyMiddleware' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/PrepareBodyMiddleware.php',
        'GuzzleHttp\\Promise\\AggregateException' => __DIR__ . '/..' . '/guzzlehttp/promises/src/AggregateException.php',
        'GuzzleHttp\\Promise\\CancellationException' => __DIR__ . '/..' . '/guzzlehttp/promises/src/CancellationException.php',
        'GuzzleHttp\\Promise\\Coroutine' => __DIR__ . '/..' . '/guzzlehttp/promises/src/Coroutine.php',
        'GuzzleHttp\\Promise\\Create' => __DIR__ . '/..' . '/guzzlehttp/promises/src/Create.php',
        'GuzzleHttp\\Promise\\Each' => __DIR__ . '/..' . '/guzzlehttp/promises/src/Each.php',
        'GuzzleHttp\\Promise\\EachPromise' => __DIR__ . '/..' . '/guzzlehttp/promises/src/EachPromise.php',
        'GuzzleHttp\\Promise\\FulfilledPromise' => __DIR__ . '/..' . '/guzzlehttp/promises/src/FulfilledPromise.php',
        'GuzzleHttp\\Promise\\Is' => __DIR__ . '/..' . '/guzzlehttp/promises/src/Is.php',
        'GuzzleHttp\\Promise\\Promise' => __DIR__ . '/..' . '/guzzlehttp/promises/src/Promise.php',
        'GuzzleHttp\\Promise\\PromiseInterface' => __DIR__ . '/..' . '/guzzlehttp/promises/src/PromiseInterface.php',
        'GuzzleHttp\\Promise\\PromisorInterface' => __DIR__ . '/..' . '/guzzlehttp/promises/src/PromisorInterface.php',
        'GuzzleHttp\\Promise\\RejectedPromise' => __DIR__ . '/..' . '/guzzlehttp/promises/src/RejectedPromise.php',
        'GuzzleHttp\\Promise\\RejectionException' => __DIR__ . '/..' . '/guzzlehttp/promises/src/RejectionException.php',
        'GuzzleHttp\\Promise\\TaskQueue' => __DIR__ . '/..' . '/guzzlehttp/promises/src/TaskQueue.php',
        'GuzzleHttp\\Promise\\TaskQueueInterface' => __DIR__ . '/..' . '/guzzlehttp/promises/src/TaskQueueInterface.php',
        'GuzzleHttp\\Promise\\Utils' => __DIR__ . '/..' . '/guzzlehttp/promises/src/Utils.php',
        'GuzzleHttp\\Psr7\\AppendStream' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/AppendStream.php',
        'GuzzleHttp\\Psr7\\BufferStream' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/BufferStream.php',
        'GuzzleHttp\\Psr7\\CachingStream' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/CachingStream.php',
        'GuzzleHttp\\Psr7\\DroppingStream' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/DroppingStream.php',
        'GuzzleHttp\\Psr7\\FnStream' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/FnStream.php',
        'GuzzleHttp\\Psr7\\Header' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/Header.php',
        'GuzzleHttp\\Psr7\\InflateStream' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/InflateStream.php',
        'GuzzleHttp\\Psr7\\LazyOpenStream' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/LazyOpenStream.php',
        'GuzzleHttp\\Psr7\\LimitStream' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/LimitStream.php',
        'GuzzleHttp\\Psr7\\Message' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/Message.php',
        'GuzzleHttp\\Psr7\\MessageTrait' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/MessageTrait.php',
        'GuzzleHttp\\Psr7\\MimeType' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/MimeType.php',
        'GuzzleHttp\\Psr7\\MultipartStream' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/MultipartStream.php',
        'GuzzleHttp\\Psr7\\NoSeekStream' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/NoSeekStream.php',
        'GuzzleHttp\\Psr7\\PumpStream' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/PumpStream.php',
        'GuzzleHttp\\Psr7\\Query' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/Query.php',
        'GuzzleHttp\\Psr7\\Request' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/Request.php',
        'GuzzleHttp\\Psr7\\Response' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/Response.php',
        'GuzzleHttp\\Psr7\\Rfc7230' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/Rfc7230.php',
        'GuzzleHttp\\Psr7\\ServerRequest' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/ServerRequest.php',
        'GuzzleHttp\\Psr7\\Stream' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/Stream.php',
        'GuzzleHttp\\Psr7\\StreamDecoratorTrait' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/StreamDecoratorTrait.php',
        'GuzzleHttp\\Psr7\\StreamWrapper' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/StreamWrapper.php',
        'GuzzleHttp\\Psr7\\UploadedFile' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/UploadedFile.php',
        'GuzzleHttp\\Psr7\\Uri' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/Uri.php',
        'GuzzleHttp\\Psr7\\UriNormalizer' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/UriNormalizer.php',
        'GuzzleHttp\\Psr7\\UriResolver' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/UriResolver.php',
        'GuzzleHttp\\Psr7\\Utils' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/Utils.php',
        'GuzzleHttp\\RedirectMiddleware' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/RedirectMiddleware.php',
        'GuzzleHttp\\RequestOptions' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/RequestOptions.php',
        'GuzzleHttp\\RetryMiddleware' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/RetryMiddleware.php',
        'GuzzleHttp\\TransferStats' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/TransferStats.php',
        'GuzzleHttp\\UriTemplate' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/UriTemplate.php',
        'GuzzleHttp\\Utils' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Utils.php',
        'Normalizer' => __DIR__ . '/..' . '/symfony/polyfill-intl-normalizer/Resources/stubs/Normalizer.php',
        'Phrase\\ApiException' => __DIR__ . '/..' . '/phrase/phrase-php/lib/ApiException.php',
        'Phrase\\Api\\AccountsApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/AccountsApi.php',
        'Phrase\\Api\\AuthorizationsApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/AuthorizationsApi.php',
        'Phrase\\Api\\BitbucketSyncApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/BitbucketSyncApi.php',
        'Phrase\\Api\\BlacklistedKeysApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/BlacklistedKeysApi.php',
        'Phrase\\Api\\BranchesApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/BranchesApi.php',
        'Phrase\\Api\\CommentsApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/CommentsApi.php',
        'Phrase\\Api\\DistributionsApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/DistributionsApi.php',
        'Phrase\\Api\\DocumentsApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/DocumentsApi.php',
        'Phrase\\Api\\FormatsApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/FormatsApi.php',
        'Phrase\\Api\\GitHubSyncApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/GitHubSyncApi.php',
        'Phrase\\Api\\GitLabSyncApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/GitLabSyncApi.php',
        'Phrase\\Api\\GlossariesApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/GlossariesApi.php',
        'Phrase\\Api\\GlossaryTermTranslationsApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/GlossaryTermTranslationsApi.php',
        'Phrase\\Api\\GlossaryTermsApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/GlossaryTermsApi.php',
        'Phrase\\Api\\InvitationsApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/InvitationsApi.php',
        'Phrase\\Api\\JobLocalesApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/JobLocalesApi.php',
        'Phrase\\Api\\JobsApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/JobsApi.php',
        'Phrase\\Api\\KeysApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/KeysApi.php',
        'Phrase\\Api\\LocalesApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/LocalesApi.php',
        'Phrase\\Api\\MembersApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/MembersApi.php',
        'Phrase\\Api\\OrdersApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/OrdersApi.php',
        'Phrase\\Api\\ProjectsApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/ProjectsApi.php',
        'Phrase\\Api\\ReleasesApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/ReleasesApi.php',
        'Phrase\\Api\\ScreenshotMarkersApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/ScreenshotMarkersApi.php',
        'Phrase\\Api\\ScreenshotsApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/ScreenshotsApi.php',
        'Phrase\\Api\\SpacesApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/SpacesApi.php',
        'Phrase\\Api\\StyleGuidesApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/StyleGuidesApi.php',
        'Phrase\\Api\\TagsApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/TagsApi.php',
        'Phrase\\Api\\TeamsApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/TeamsApi.php',
        'Phrase\\Api\\TranslationsApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/TranslationsApi.php',
        'Phrase\\Api\\UploadsApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/UploadsApi.php',
        'Phrase\\Api\\UsersApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/UsersApi.php',
        'Phrase\\Api\\VersionsHistoryApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/VersionsHistoryApi.php',
        'Phrase\\Api\\WebhooksApi' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Api/WebhooksApi.php',
        'Phrase\\Configuration' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Configuration.php',
        'Phrase\\HeaderSelector' => __DIR__ . '/..' . '/phrase/phrase-php/lib/HeaderSelector.php',
        'Phrase\\Model\\Account' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/Account.php',
        'Phrase\\Model\\AccountDetails' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/AccountDetails.php',
        'Phrase\\Model\\AccountDetails1' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/AccountDetails1.php',
        'Phrase\\Model\\AffectedCount' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/AffectedCount.php',
        'Phrase\\Model\\AffectedResources' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/AffectedResources.php',
        'Phrase\\Model\\Authorization' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/Authorization.php',
        'Phrase\\Model\\AuthorizationCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/AuthorizationCreateParameters.php',
        'Phrase\\Model\\AuthorizationUpdateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/AuthorizationUpdateParameters.php',
        'Phrase\\Model\\AuthorizationWithToken' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/AuthorizationWithToken.php',
        'Phrase\\Model\\AuthorizationWithToken1' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/AuthorizationWithToken1.php',
        'Phrase\\Model\\BitbucketSync' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/BitbucketSync.php',
        'Phrase\\Model\\BitbucketSyncExportParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/BitbucketSyncExportParameters.php',
        'Phrase\\Model\\BitbucketSyncExportResponse' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/BitbucketSyncExportResponse.php',
        'Phrase\\Model\\BitbucketSyncImportParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/BitbucketSyncImportParameters.php',
        'Phrase\\Model\\BlacklistedKey' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/BlacklistedKey.php',
        'Phrase\\Model\\BlacklistedKeyCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/BlacklistedKeyCreateParameters.php',
        'Phrase\\Model\\BlacklistedKeyUpdateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/BlacklistedKeyUpdateParameters.php',
        'Phrase\\Model\\Branch' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/Branch.php',
        'Phrase\\Model\\BranchCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/BranchCreateParameters.php',
        'Phrase\\Model\\BranchMergeParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/BranchMergeParameters.php',
        'Phrase\\Model\\BranchUpdateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/BranchUpdateParameters.php',
        'Phrase\\Model\\Comment' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/Comment.php',
        'Phrase\\Model\\CommentCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/CommentCreateParameters.php',
        'Phrase\\Model\\CommentMarkReadParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/CommentMarkReadParameters.php',
        'Phrase\\Model\\CommentUpdateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/CommentUpdateParameters.php',
        'Phrase\\Model\\Distribution' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/Distribution.php',
        'Phrase\\Model\\DistributionCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/DistributionCreateParameters.php',
        'Phrase\\Model\\DistributionPreview' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/DistributionPreview.php',
        'Phrase\\Model\\DistributionUpdateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/DistributionUpdateParameters.php',
        'Phrase\\Model\\Document' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/Document.php',
        'Phrase\\Model\\Format' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/Format.php',
        'Phrase\\Model\\GithubSyncExportParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/GithubSyncExportParameters.php',
        'Phrase\\Model\\GithubSyncImportParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/GithubSyncImportParameters.php',
        'Phrase\\Model\\GitlabSync' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/GitlabSync.php',
        'Phrase\\Model\\GitlabSyncExport' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/GitlabSyncExport.php',
        'Phrase\\Model\\GitlabSyncExportParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/GitlabSyncExportParameters.php',
        'Phrase\\Model\\GitlabSyncHistory' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/GitlabSyncHistory.php',
        'Phrase\\Model\\GitlabSyncImportParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/GitlabSyncImportParameters.php',
        'Phrase\\Model\\Glossary' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/Glossary.php',
        'Phrase\\Model\\GlossaryCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/GlossaryCreateParameters.php',
        'Phrase\\Model\\GlossaryTerm' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/GlossaryTerm.php',
        'Phrase\\Model\\GlossaryTermCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/GlossaryTermCreateParameters.php',
        'Phrase\\Model\\GlossaryTermTranslation' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/GlossaryTermTranslation.php',
        'Phrase\\Model\\GlossaryTermTranslationCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/GlossaryTermTranslationCreateParameters.php',
        'Phrase\\Model\\GlossaryTermTranslationUpdateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/GlossaryTermTranslationUpdateParameters.php',
        'Phrase\\Model\\GlossaryTermUpdateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/GlossaryTermUpdateParameters.php',
        'Phrase\\Model\\GlossaryUpdateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/GlossaryUpdateParameters.php',
        'Phrase\\Model\\InlineResponse422' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/InlineResponse422.php',
        'Phrase\\Model\\InlineResponse422Errors' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/InlineResponse422Errors.php',
        'Phrase\\Model\\Invitation' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/Invitation.php',
        'Phrase\\Model\\InvitationCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/InvitationCreateParameters.php',
        'Phrase\\Model\\InvitationUpdateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/InvitationUpdateParameters.php',
        'Phrase\\Model\\Job' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/Job.php',
        'Phrase\\Model\\JobCompleteParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/JobCompleteParameters.php',
        'Phrase\\Model\\JobCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/JobCreateParameters.php',
        'Phrase\\Model\\JobDetails' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/JobDetails.php',
        'Phrase\\Model\\JobDetails1' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/JobDetails1.php',
        'Phrase\\Model\\JobKeysCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/JobKeysCreateParameters.php',
        'Phrase\\Model\\JobLocale' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/JobLocale.php',
        'Phrase\\Model\\JobLocaleCompleteParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/JobLocaleCompleteParameters.php',
        'Phrase\\Model\\JobLocaleReopenParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/JobLocaleReopenParameters.php',
        'Phrase\\Model\\JobLocaleUpdateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/JobLocaleUpdateParameters.php',
        'Phrase\\Model\\JobLocalesCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/JobLocalesCreateParameters.php',
        'Phrase\\Model\\JobPreview' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/JobPreview.php',
        'Phrase\\Model\\JobReopenParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/JobReopenParameters.php',
        'Phrase\\Model\\JobStartParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/JobStartParameters.php',
        'Phrase\\Model\\JobUpdateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/JobUpdateParameters.php',
        'Phrase\\Model\\KeyCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/KeyCreateParameters.php',
        'Phrase\\Model\\KeyPreview' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/KeyPreview.php',
        'Phrase\\Model\\KeyUpdateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/KeyUpdateParameters.php',
        'Phrase\\Model\\KeysSearchParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/KeysSearchParameters.php',
        'Phrase\\Model\\KeysTagParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/KeysTagParameters.php',
        'Phrase\\Model\\KeysUntagParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/KeysUntagParameters.php',
        'Phrase\\Model\\Locale' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/Locale.php',
        'Phrase\\Model\\LocaleCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/LocaleCreateParameters.php',
        'Phrase\\Model\\LocaleDetails' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/LocaleDetails.php',
        'Phrase\\Model\\LocaleDetails1' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/LocaleDetails1.php',
        'Phrase\\Model\\LocalePreview' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/LocalePreview.php',
        'Phrase\\Model\\LocaleStatistics' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/LocaleStatistics.php',
        'Phrase\\Model\\LocaleUpdateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/LocaleUpdateParameters.php',
        'Phrase\\Model\\Member' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/Member.php',
        'Phrase\\Model\\MemberUpdateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/MemberUpdateParameters.php',
        'Phrase\\Model\\ModelInterface' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/ModelInterface.php',
        'Phrase\\Model\\OrderConfirmParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/OrderConfirmParameters.php',
        'Phrase\\Model\\OrderCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/OrderCreateParameters.php',
        'Phrase\\Model\\Project' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/Project.php',
        'Phrase\\Model\\ProjectCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/ProjectCreateParameters.php',
        'Phrase\\Model\\ProjectDetails' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/ProjectDetails.php',
        'Phrase\\Model\\ProjectDetails1' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/ProjectDetails1.php',
        'Phrase\\Model\\ProjectLocales' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/ProjectLocales.php',
        'Phrase\\Model\\ProjectLocales1' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/ProjectLocales1.php',
        'Phrase\\Model\\ProjectShort' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/ProjectShort.php',
        'Phrase\\Model\\ProjectUpdateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/ProjectUpdateParameters.php',
        'Phrase\\Model\\Release' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/Release.php',
        'Phrase\\Model\\ReleaseCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/ReleaseCreateParameters.php',
        'Phrase\\Model\\ReleasePreview' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/ReleasePreview.php',
        'Phrase\\Model\\ReleaseUpdateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/ReleaseUpdateParameters.php',
        'Phrase\\Model\\Screenshot' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/Screenshot.php',
        'Phrase\\Model\\ScreenshotCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/ScreenshotCreateParameters.php',
        'Phrase\\Model\\ScreenshotMarker' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/ScreenshotMarker.php',
        'Phrase\\Model\\ScreenshotMarkerCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/ScreenshotMarkerCreateParameters.php',
        'Phrase\\Model\\ScreenshotMarkerUpdateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/ScreenshotMarkerUpdateParameters.php',
        'Phrase\\Model\\ScreenshotUpdateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/ScreenshotUpdateParameters.php',
        'Phrase\\Model\\Space' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/Space.php',
        'Phrase\\Model\\SpaceCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/SpaceCreateParameters.php',
        'Phrase\\Model\\SpaceUpdateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/SpaceUpdateParameters.php',
        'Phrase\\Model\\SpacesProjectsCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/SpacesProjectsCreateParameters.php',
        'Phrase\\Model\\Styleguide' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/Styleguide.php',
        'Phrase\\Model\\StyleguideCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/StyleguideCreateParameters.php',
        'Phrase\\Model\\StyleguideDetails' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/StyleguideDetails.php',
        'Phrase\\Model\\StyleguideDetails1' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/StyleguideDetails1.php',
        'Phrase\\Model\\StyleguidePreview' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/StyleguidePreview.php',
        'Phrase\\Model\\StyleguideUpdateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/StyleguideUpdateParameters.php',
        'Phrase\\Model\\Tag' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/Tag.php',
        'Phrase\\Model\\TagCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TagCreateParameters.php',
        'Phrase\\Model\\TagWithStats' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TagWithStats.php',
        'Phrase\\Model\\TagWithStats1' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TagWithStats1.php',
        'Phrase\\Model\\TagWithStats1Statistics' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TagWithStats1Statistics.php',
        'Phrase\\Model\\TagWithStats1Statistics1' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TagWithStats1Statistics1.php',
        'Phrase\\Model\\Team' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/Team.php',
        'Phrase\\Model\\TeamCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TeamCreateParameters.php',
        'Phrase\\Model\\TeamDetail' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TeamDetail.php',
        'Phrase\\Model\\TeamUpdateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TeamUpdateParameters.php',
        'Phrase\\Model\\TeamsProjectsCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TeamsProjectsCreateParameters.php',
        'Phrase\\Model\\TeamsSpacesCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TeamsSpacesCreateParameters.php',
        'Phrase\\Model\\TeamsUsersCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TeamsUsersCreateParameters.php',
        'Phrase\\Model\\Translation' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/Translation.php',
        'Phrase\\Model\\TranslationCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TranslationCreateParameters.php',
        'Phrase\\Model\\TranslationDetails' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TranslationDetails.php',
        'Phrase\\Model\\TranslationDetails1' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TranslationDetails1.php',
        'Phrase\\Model\\TranslationExcludeParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TranslationExcludeParameters.php',
        'Phrase\\Model\\TranslationIncludeParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TranslationIncludeParameters.php',
        'Phrase\\Model\\TranslationKey' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TranslationKey.php',
        'Phrase\\Model\\TranslationKeyDetails' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TranslationKeyDetails.php',
        'Phrase\\Model\\TranslationKeyDetails1' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TranslationKeyDetails1.php',
        'Phrase\\Model\\TranslationOrder' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TranslationOrder.php',
        'Phrase\\Model\\TranslationReviewParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TranslationReviewParameters.php',
        'Phrase\\Model\\TranslationUnverifyParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TranslationUnverifyParameters.php',
        'Phrase\\Model\\TranslationUpdateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TranslationUpdateParameters.php',
        'Phrase\\Model\\TranslationVerifyParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TranslationVerifyParameters.php',
        'Phrase\\Model\\TranslationVersion' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TranslationVersion.php',
        'Phrase\\Model\\TranslationVersionWithUser' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TranslationVersionWithUser.php',
        'Phrase\\Model\\TranslationVersionWithUser1' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TranslationVersionWithUser1.php',
        'Phrase\\Model\\TranslationsExcludeParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TranslationsExcludeParameters.php',
        'Phrase\\Model\\TranslationsIncludeParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TranslationsIncludeParameters.php',
        'Phrase\\Model\\TranslationsReviewParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TranslationsReviewParameters.php',
        'Phrase\\Model\\TranslationsSearchParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TranslationsSearchParameters.php',
        'Phrase\\Model\\TranslationsUnverifyParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TranslationsUnverifyParameters.php',
        'Phrase\\Model\\TranslationsVerifyParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/TranslationsVerifyParameters.php',
        'Phrase\\Model\\Upload' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/Upload.php',
        'Phrase\\Model\\UploadCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/UploadCreateParameters.php',
        'Phrase\\Model\\UploadSummary' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/UploadSummary.php',
        'Phrase\\Model\\User' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/User.php',
        'Phrase\\Model\\UserPreview' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/UserPreview.php',
        'Phrase\\Model\\Webhook' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/Webhook.php',
        'Phrase\\Model\\WebhookCreateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/WebhookCreateParameters.php',
        'Phrase\\Model\\WebhookUpdateParameters' => __DIR__ . '/..' . '/phrase/phrase-php/lib/Model/WebhookUpdateParameters.php',
        'Phrase\\ObjectSerializer' => __DIR__ . '/..' . '/phrase/phrase-php/lib/ObjectSerializer.php',
        'Phrase\\WP\\Admin\\Settings' => __DIR__ . '/../..' . '/inc/Admin/Settings.php',
        'Phrase\\WP\\CLI\\UpdateTermMetaCommand' => __DIR__ . '/../..' . '/inc/CLI/UpdateTermMetaCommand.php',
        'Phrase\\WP\\Cron\\UpdateTermMetaData' => __DIR__ . '/../..' . '/inc/Cron/UpdateTermMetaData.php',
        'Phrase\\WP\\PhraseAPI\\PhraseAPI' => __DIR__ . '/../..' . '/inc/PhraseAPI/PhraseAPI.php',
        'Phrase\\WP\\RestAPI\\Controller\\Locales' => __DIR__ . '/../..' . '/inc/RestAPI/Controller/Locales.php',
        'Phrase\\WP\\RestAPI\\Controller\\Projects' => __DIR__ . '/../..' . '/inc/RestAPI/Controller/Projects.php',
        'Phrase\\WP\\RestAPI\\Controller\\PushContent' => __DIR__ . '/../..' . '/inc/RestAPI/Controller/PushContent.php',
        'Phrase\\WP\\RestAPI\\Controller\\PushTranslation' => __DIR__ . '/../..' . '/inc/RestAPI/Controller/PushTranslation.php',
        'Phrase\\WP\\RestAPI\\Controller\\Status' => __DIR__ . '/../..' . '/inc/RestAPI/Controller/Status.php',
        'Phrase\\WP\\RestAPI\\Controller\\Translations' => __DIR__ . '/../..' . '/inc/RestAPI/Controller/Translations.php',
        'Psr\\Http\\Message\\MessageInterface' => __DIR__ . '/..' . '/psr/http-message/src/MessageInterface.php',
        'Psr\\Http\\Message\\RequestInterface' => __DIR__ . '/..' . '/psr/http-message/src/RequestInterface.php',
        'Psr\\Http\\Message\\ResponseInterface' => __DIR__ . '/..' . '/psr/http-message/src/ResponseInterface.php',
        'Psr\\Http\\Message\\ServerRequestInterface' => __DIR__ . '/..' . '/psr/http-message/src/ServerRequestInterface.php',
        'Psr\\Http\\Message\\StreamInterface' => __DIR__ . '/..' . '/psr/http-message/src/StreamInterface.php',
        'Psr\\Http\\Message\\UploadedFileInterface' => __DIR__ . '/..' . '/psr/http-message/src/UploadedFileInterface.php',
        'Psr\\Http\\Message\\UriInterface' => __DIR__ . '/..' . '/psr/http-message/src/UriInterface.php',
        'Symfony\\Polyfill\\Intl\\Idn\\Idn' => __DIR__ . '/..' . '/symfony/polyfill-intl-idn/Idn.php',
        'Symfony\\Polyfill\\Intl\\Idn\\Info' => __DIR__ . '/..' . '/symfony/polyfill-intl-idn/Info.php',
        'Symfony\\Polyfill\\Intl\\Idn\\Resources\\unidata\\DisallowedRanges' => __DIR__ . '/..' . '/symfony/polyfill-intl-idn/Resources/unidata/DisallowedRanges.php',
        'Symfony\\Polyfill\\Intl\\Idn\\Resources\\unidata\\Regex' => __DIR__ . '/..' . '/symfony/polyfill-intl-idn/Resources/unidata/Regex.php',
        'Symfony\\Polyfill\\Intl\\Normalizer\\Normalizer' => __DIR__ . '/..' . '/symfony/polyfill-intl-normalizer/Normalizer.php',
        'Symfony\\Polyfill\\Php72\\Php72' => __DIR__ . '/..' . '/symfony/polyfill-php72/Php72.php',
        'WP_Requirements_Check' => __DIR__ . '/..' . '/wearerequired/wp-requirements-check/WP_Requirements_Check.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfc8574130448d00b66871ae3dac6b736::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfc8574130448d00b66871ae3dac6b736::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitfc8574130448d00b66871ae3dac6b736::$classMap;

        }, null, ClassLoader::class);
    }
}
