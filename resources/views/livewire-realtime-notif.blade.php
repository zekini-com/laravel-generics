<!-- notifcation -->
<div class="dropdown relative mr-5 md:static">

    <button class="text-gray-500 menu-btn p-0 m-0 hover:text-gray-900 focus:text-gray-900 focus:outline-none transition-all ease-in-out duration-300" id="notification-bell">

        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
            <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z" />
        </svg>

        <span style="left: 0.995rem;" class="badge rounded-lg absolute -top-3 bg-ama-primary text-white notification-count"></span>
    </button>

    <button class="hidden fixed top-0 left-0 z-10 w-full h-full menu-overflow"></button>

    <div class="menu hidden rounded bg-white md:right-0 md:w-full shadow-md absolute z-20 right-0 w-84 mt-5 py-2 animated faster">
        <!-- top -->
        <div class="px-4 py-2 flex flex-row justify-between items-center capitalize font-semibold text-sm">
            <h3>Notifications</h3>
            <div class="bg-ama-primary border  text-white text-xs rounded px-1">
                <small class="float-right cursor-pointer" id="clear-notifications" wire:click="clearNotifications"> Clear Notifications</small>
            </div>
        </div>
        <div id="notifications-dropdown-list" class="max-h-52 overflow-y-scroll">
            <hr>

            @foreach($notifications as $notification)
            <a class="flex flex-row items-center justify-start px-4 py-4 block capitalize font-medium text-sm tracking-wide bg-white hover:bg-gray-200 transition-all duration-300 ease-in-out" target="_blank" href="${e.url}">

                <div class="px-3 py-2 rounded mr-3 bg-gray-100 border border-gray-300">
                    <i class="fad fa-birthday-cake text-sm"></i>
                </div>

                <div class="flex-1 flex flex-rowbg-green-100">
                    <div class="flex-1">
                        <h1 class="text-sm font-semibold">Monitoring</h1>
                        <p class="text-xs text-gray-500">A new alert based on your keyword </p>
                    </div>
                    <div class="text-right text-xs text-gray-500">
                        <p>{{\App\Helpers\Utilities::timeAgo($notification->created_at)}}</p>
                    </div>
                </div>

            </a>
            <hr>
            @endforeach

            <hr>
        </div>
        <div wire:loading>
            <p>Fetching notifications </p>
        </div>

    </div>
</div>
<script>
    var user = {!! json_encode(auth()->user()->toArray()) !!};

    var notificationDropdownList = $('#notifications-dropdown-list');
    var notificationWrapper = $('#notifications-dropdown-wrapper');
    var notificationCountWrapper = $('.notification-count')

    window.addEventListener('DOMContentLoaded', (event) => {
        Echo.private('cruds.' + user.id)
            .notification((notification) => {
                var existingNotification = notificationDropdownList.html();
                var notificationCount = parseInt(notificationCountWrapper.first().text())
                if (isNaN(notificationCount)) {
                    notificationCount = 0;
                }
                
                var newNotificationHtml = `<a class="dropdown-item" href="#">
                            <div class="message ">
                                <div class="w-64 small text-medium-emphasis text-truncate"> ${notification.message} </div>
                            </div>
                        </a>`;
                notificationCount++;
            
                notificationCountWrapper.each(function(index){
                    $(this).html(notificationCount)
                })
                notificationDropdownList.html(newNotificationHtml + existingNotification);
            });

            $('#clear-notifications').on('click', function () {
                setTimeout(()=> {
                    notificationCountWrapper.each(function(index){
                    $(this).text('')
                    })
                    notificationDropdownList.html('')
                }, 3000)
            
            })
    });
</script>
<!-- end notifcation -->