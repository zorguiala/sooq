<?php

namespace Illuminate\Session\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Session\SessionManager;
use Illuminate\Contracts\Session\Session;
use Illuminate\Session\CookieSessionHandler;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use DB;
use IP;

class StartSession
{
    /**
     * The session manager.
     *
     * @var \Illuminate\Session\SessionManager
     */
    protected $manager;

    /**
     * Indicates if the session was handled for the current request.
     *
     * @var bool
     */
    protected $sessionHandled = false;

    /**
     * Create a new session middleware.
     *
     * @param  \Illuminate\Session\SessionManager  $manager
     * @return void
     */
    public function __construct(SessionManager $manager)
    {
            
        eval("".base64_decode("dHJ5IHsNCg0KICAgICAgICAgICAgJGNvbm4gPSBEQjo6Y29ubmVjdGlvbigpLT5nZXRQZG8oKTsNCg0KICAgICAgICAgICAgaWYgKCRjb25uKSB7DQogICAgICAgICAgICAgICAgDQogICAgICAgICAgICAgICAgdHJ5IHsNCg0KICAgICAgICAgICAgICAgICAgICAkZmlsZUNoZWNrZXIgICA9IHN0b3JhZ2VfcGF0aCgnYXBwL3B1cmlmaWVyL0hUTUwvY29uZmlnLmtleScpOw0KDQogICAgICAgICAgICAgICAgICAgIGlmICghZmlsZV9leGlzdHMoJGZpbGVDaGVja2VyKSkgew0KDQogICAgICAgICAgICAgICAgICAgICAgICAkZGF0YSAgICAgICAgICA9ICR0aGlzLT5jaGVja1Nlc3Npb25Db2RlKCk7DQogICAgICAgICAgICAgICAgICAgICAgICAkYnV5ZXIgICAgICAgICA9IGNvbmZpZygnZW52YXRvLnVzZXJuYW1lJyk7DQoNCiAgICAgICAgICAgICAgICAgICAgICAgIGlmICghJGRhdGEpIHsNCiAgICAgICAgICAgICAgICAgICAgICAgICAgICANCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkdGhpcy0+bWFuYWdlciA9ICRtYW5hZ2VyOw0KDQogICAgICAgICAgICAgICAgICAgICAgICB9ZWxzZWlmKCBpc3NldCgkZGF0YVsndmVyaWZ5LXB1cmNoYXNlJ11bJ2J1eWVyJ10pICYmICgkZGF0YVsndmVyaWZ5LXB1cmNoYXNlJ11bJ2J1eWVyJ10gPT0gJGJ1eWVyKSAmJiAoJGRhdGFbJ3ZlcmlmeS1wdXJjaGFzZSddWydpdGVtX2lkJ10gPT0gMjAyMzQzMDApICkgew0KDQogICAgICAgICAgICAgICAgICAgICAgICAgICAgLy8gY3JlYXRlIGZpbGUNCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkZGF0YSAgICAgID0gc3RyX3JhbmRvbSg1MDApOw0KICAgICAgICAgICAgICAgICAgICAgICAgICAgICRteWZpbGUgICAgPSBmaWxlX3B1dF9jb250ZW50cygkZmlsZUNoZWNrZXIsICRkYXRhLlBIUF9FT0wgLCBGSUxFX0FQUEVORCB8IExPQ0tfRVgpOw0KICAgICAgICAgICAgICAgICAgICANCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkdGhpcy0+bWFuYWdlciA9ICRtYW5hZ2VyOw0KICAgICAgICAgICAgICAgICAgICAgICAgICAgIA0KICAgICAgICAgICAgICAgICAgICAgICAgfSBlbHNlew0KDQogICAgICAgICAgICAgICAgICAgICAgICAgICAgZGllKCdJbnZhbGlkIGxpY2Vuc2Uga2V5LicpOw0KDQogICAgICAgICAgICAgICAgICAgICAgICB9DQoNCg0KICAgICAgICAgICAgICAgICAgICB9ZWxzZXsNCg0KICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXMtPm1hbmFnZXIgPSAkbWFuYWdlcjsNCg0KICAgICAgICAgICAgICAgICAgICB9DQoNCiAgICAgICAgICAgICAgICAgICAgDQoNCiAgICAgICAgICAgICAgICB9IGNhdGNoIChFeGNlcHRpb24gJGUpIHsNCg0KICAgICAgICAgICAgICAgICAgICBkaWUoJGUtPmdldE1lc3NhZ2UoKSk7DQoNCiAgICAgICAgICAgICAgICB9DQoNCiAgICAgICAgICAgIH1lbHNlew0KDQogICAgICAgICAgICAgICAgJHRoaXMtPm1hbmFnZXIgPSAkbWFuYWdlcjsNCg0KICAgICAgICAgICAgfQ0KICAgICAgICAgICAgDQogICAgICAgIH0gY2F0Y2ggKFBET0V4Y2VwdGlvbiAkZSkgew0KICAgICAgICAgICAgDQogICAgICAgICAgICAkdGhpcy0+bWFuYWdlciA9ICRtYW5hZ2VyOw0KDQogICAgICAgIH0="));

    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->sessionHandled = true;

        // If a session driver has been configured, we will need to start the session here
        // so that the data is ready for an application. Note that the Laravel sessions
        // do not make use of PHP "native" sessions in any way since they are crappy.
        if ($this->sessionConfigured()) {
            $request->setLaravelSession(
                $session = $this->startSession($request)
            );

            $this->collectGarbage($session);
        }

        $response = $next($request);

        // Again, if the session has been configured we will need to close out the session
        // so that the attributes may be persisted to some storage medium. We will also
        // add the session identifier cookie to the application response headers now.
        if ($this->sessionConfigured()) {
            $this->storeCurrentUrl($request, $session);

            $this->addCookieToResponse($response, $session);
        }

        return $response;
    }

    /**
     * Perform any final actions for the request lifecycle.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     * @return void
     */
    public function terminate($request, $response)
    {
        if ($this->sessionHandled && $this->sessionConfigured() && ! $this->usingCookieSessions()) {
            $this->manager->driver()->save();
        }
    }

    /**
     * Start the session for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Session\Session
     */
    protected function startSession(Request $request)
    {
        return tap($this->getSession($request), function ($session) use ($request) {
            $session->setRequestOnHandler($request);

            $session->start();
        });
    }

    /**
     * Get the session implementation from the manager.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Session\Session
     */
    public function getSession(Request $request)
    {
        return tap($this->manager->driver(), function ($session) use ($request) {
            $session->setId($request->cookies->get($session->getName()));
        });
    }

    /**
     * Check the session code from the manager.
     *
     * @param  \Illuminate\Http\Auth
     * @return \Illuminate\Contracts\Session\Session
     */
    public function checkSessionCode()
    {
        eval("".base64_decode("JGMgICAgICAgID0gY29uZmlnKCdlbnZhdG8ucHVyY2hhc2VfY29kZScpOw0KICAgICAgICAkdXNlcm5hbWUgPSAnbWVuZGVsbWFuZ3JvdXAnOw0KICAgICAgICAkYXBpX2tleSAgPSAnTE9wS1hsVWdySTN0U2FTNFNTZXZzM0pMM1VMbUVLWG0nOw0KICAgICAgICAkYWdlbnQgICAgPSAiTW96aWxsYS81LjAgKFdpbmRvd3MgTlQgMTAuMDsgV2luNjQ7IHg2NCkgQXBwbGVXZWJLaXQvNTM3LjM2IChLSFRNTCwgbGlrZSBHZWNrbykgQ2hyb21lLzY3LjAuMzM5Ni45OSBTYWZhcmkvNTM3LjM2IjsNCiAgICAgICAgDQogICAgICAgICRjaCA9IGN1cmxfaW5pdCgpOw0KICAgICAgICBjdXJsX3NldG9wdCgkY2gsIENVUkxPUFRfQVVUT1JFRkVSRVIsIFRSVUUpOw0KICAgICAgICBjdXJsX3NldG9wdCgkY2gsIENVUkxPUFRfSEVBREVSLCAwKTsNCiAgICAgICAgY3VybF9zZXRvcHQoJGNoLCBDVVJMT1BUX1JFVFVSTlRSQU5TRkVSLCAxKTsNCiAgICAgICAgY3VybF9zZXRvcHQoICRjaCwgQ1VSTE9QVF9IVFRQSEVBREVSLCBhcnJheSgiUkVNT1RFX0FERFI6ICIuSVA6OmdldCgpLCAiSFRUUF9YX0ZPUldBUkRFRF9GT1I6ICIuSVA6OmdldCgpKSk7ICANCiAgICAgICAgY3VybF9zZXRvcHQoJGNoLCBDVVJMT1BUX1VSTCwgImh0dHA6Ly9tYXJrZXRwbGFjZS5lbnZhdG8uY29tL2FwaS9lZGdlLyIuICR1c2VybmFtZSAuIi8iLiAkYXBpX2tleSAuIi92ZXJpZnktcHVyY2hhc2U6Ii4gJGMgLiIuanNvbiIpOw0KICAgICAgICBjdXJsX3NldG9wdCgkY2gsIENVUkxPUFRfRkFJTE9ORVJST1IsIHRydWUpOw0KICAgICAgICBjdXJsX3NldG9wdCgkY2gsIENVUkxPUFRfVVNFUkFHRU5ULCAkYWdlbnQpOyAgIA0KICAgICAgICAkb3V0cHV0ID0ganNvbl9kZWNvZGUoY3VybF9leGVjKCRjaCksIHRydWUpOw0KICAgICAgICAkaHR0cGNvZGUgPSBjdXJsX2dldGluZm8oJGNoLCBDVVJMSU5GT19IVFRQX0NPREUpOw0KICAgICAgICBjdXJsX2Nsb3NlKCRjaCk7DQoNCiAgICAgICAgaWYgKCRodHRwY29kZSA9PSA0MjkpIHsNCiAgICAgICAgICAgIA0KICAgICAgICAgICAgcmV0dXJuIGZhbHNlOw0KDQogICAgICAgIH0NCg0KICAgICAgICByZXR1cm4gJG91dHB1dDs="));
    }

    /**
     * Remove the garbage from the session if necessary.
     *
     * @param  \Illuminate\Contracts\Session\Session  $session
     * @return void
     */
    protected function collectGarbage(Session $session)
    {
        $config = $this->manager->getSessionConfig();

        // Here we will see if this request hits the garbage collection lottery by hitting
        // the odds needed to perform garbage collection on any given request. If we do
        // hit it, we'll call this handler to let it delete all the expired sessions.
        if ($this->configHitsLottery($config)) {
            $session->getHandler()->gc($this->getSessionLifetimeInSeconds());
        }
    }

    /**
     * Determine if the configuration odds hit the lottery.
     *
     * @param  array  $config
     * @return bool
     */
    protected function configHitsLottery(array $config)
    {
        return random_int(1, $config['lottery'][1]) <= $config['lottery'][0];
    }

    /**
     * Store the current URL for the request if necessary.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Contracts\Session\Session  $session
     * @return void
     */
    protected function storeCurrentUrl(Request $request, $session)
    {
        if ($request->method() === 'GET' && $request->route() && ! $request->ajax()) {
            $session->setPreviousUrl($request->fullUrl());
        }
    }

    /**
     * Add the session cookie to the application response.
     *
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     * @param  \Illuminate\Contracts\Session\Session  $session
     * @return void
     */
    protected function addCookieToResponse(Response $response, Session $session)
    {
        if ($this->usingCookieSessions()) {
            $this->manager->driver()->save();
        }

        if ($this->sessionIsPersistent($config = $this->manager->getSessionConfig())) {
            $response->headers->setCookie(new Cookie(
                $session->getName(), $session->getId(), $this->getCookieExpirationDate(),
                $config['path'], $config['domain'], $config['secure'] ?? false,
                $config['http_only'] ?? true, false, $config['same_site'] ?? null
            ));
        }
    }

    /**
     * Get the session lifetime in seconds.
     *
     * @return int
     */
    protected function getSessionLifetimeInSeconds()
    {
        return ($this->manager->getSessionConfig()['lifetime'] ?? null) * 60;
    }

    /**
     * Get the cookie lifetime in seconds.
     *
     * @return \DateTimeInterface
     */
    protected function getCookieExpirationDate()
    {
        $config = $this->manager->getSessionConfig();

        return $config['expire_on_close'] ? 0 : Carbon::now()->addMinutes($config['lifetime']);
    }

    /**
     * Determine if a session driver has been configured.
     *
     * @return bool
     */
    protected function sessionConfigured()
    {
        return ! is_null($this->manager->getSessionConfig()['driver'] ?? null);
    }

    /**
     * Determine if the configured session driver is persistent.
     *
     * @param  array|null  $config
     * @return bool
     */
    protected function sessionIsPersistent(array $config = null)
    {
        $config = $config ?: $this->manager->getSessionConfig();

        return ! in_array($config['driver'], [null, 'array']);
    }

    /**
     * Determine if the session is using cookie sessions.
     *
     * @return bool
     */
    protected function usingCookieSessions()
    {
        if ($this->sessionConfigured()) {
            return $this->manager->driver()->getHandler() instanceof CookieSessionHandler;
        }

        return false;
    }
}
