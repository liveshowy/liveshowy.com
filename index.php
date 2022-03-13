<!DOCTYPE html>
<html lang="en" class="w-screen h-screen scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com?plugins=typography,aspect-ratio,line-clamp"></script>
  <title>LiveShowy</title>
</head>
<body class="bg-violet-200 dark:bg-violet-900 text-violet-800 dark:text-violet-100 transition w-full h-full p-4">

  <main
    x-data="serverCheck"
    x-cloak
    class="grid grid-cols-1 lg:grid-cols-2 gap-4 place-content-center place-items-center h-full auto-rows-auto"
  >
    <div id="logo" class="w-full max-w-prose lg:justify-self-end">
      <?php include __DIR__ . "/images/logo_final.svg" ?>
    </div>

    <h1 class="sr-only">LiveShowy.com</h1>

    <section class="prose-lg p-8 bg-gradient-to-br from-violet-50 to-violet-100 dark:from-violet-700 dark:to-violet-800 shadow-xl max-w-prose rounded-lg flex flex-col gap-2">
      <h2 class="font-semibold text-3xl m-0 h2-0">It's like a live show, but showier.</h2>

      <p class="m-0 p-0">
        LiveShowy introduces new ways to connect on-stage performers with audience members.<br/>
        More information will be presented at <a href="https://thebigelixir.com/" class="font-bold underline decoration-2">The Big Elixir</a> 2022.
      </p>

      <ul class="not-prose p-0 flex flex-wrap gap-2 leading-none">
        <li>
          <a href="https://twitter.com/liveshowyapp">@liveshowyapp</a>
        </li>
      </ul>

      <a
        x-effect="localServerStatus"
        x-show="localServerStatus == 200"
        x-transition
        href="http://liveshowy.local"
        class="rounded-sm text-center disabled:bg-violet-700 bg-green-600 text-white px-2 py-1 font-bold"
      >
        LAUNCH
      </a>
    </section>
  </main>

  <script src="https://unpkg.com/alpinejs@3.9.1/dist/cdn.min.js" defer></script>

  <script defer>
    document.addEventListener('alpine:init', () => {
      Alpine.data('serverCheck', () => ({
        localServerStatus: null,
        pingInterval: null,
        currentRequest: null,

        init() {
          this.pingLiveShowy()

          this.pingInterval = setInterval(this.pingLiveShowy, 10000)
        },

        async pingLiveShowy() {
          // console.log('currentRequest', this.currentRequest)
          if (!this.currentRequest) {
            this.currentRequest = fetch('http://liveshowy.local/ping', {
              method: 'GET',
              keepalive: false,
              cache: 'no-cache'
            })
            .then(response => response.status)
            .catch(error => "error")
            this.localServerStatus = await this.currentRequest
            this.currentRequest = null
            // console.log('localServerStatus', this.localServerStatus)
          }
        }
      }))
    })

  </script>
</body>
</html>
