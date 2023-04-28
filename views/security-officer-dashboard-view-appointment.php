<!-- <div class="appointments-container">
    <div class="appointment-card">
        <div class="appointment-card__header">
            <p>Appointment Date: 2023/2/3</p>
            <p class="due">Coming Soon</p>
        </div>
        <div class="appointment-card__info">
            <div class="appointment-card__info-date">
                <div>
                    <h3>Made on</h3>
                    <p>
                        2023/1/3
                    </p>
                </div>
            </div>
        </div>
        <div class="appointment-card__footer">
            <div><strong>
                    For:
                </strong>
                Aston Martin DB11
            </div>
            <div class="flex items-center gap-4">
                <button style="color: var(--color-info)">
                    View QR Code
                </button>

            </div>
        </div>
    </div>
    <div class="appointment-card">
        <div class="appointment-card__header">
            <p>Appointment Date: 2023/2/3</p>
            <p class="due">Coming Soon</p>
        </div>
        <div class="appointment-card__info">
            <div class="appointment-card__info-date">
                <div>
                    <h3>Made On</h3>
                    <p>
                        2023/1/3
                    </p>
                </div>
            </div>
        </div>
        <div class="appointment-card__footer">
            <div><strong>
                    For:
                </strong>
                Aston Martin DB11
            </div>
            <div class="flex items-center gap-4">
                <button style="color: var(--color-info)">
                    View QR Code
                </button>

            </div>
        </div>
    </div>
    <div class="appointment-card">
        <div class="appointment-card__header">
            <p>Appointment Date: 2023/2/3</p>
            <p class="due">Coming Soon</p>
        </div>
        <div class="appointment-card__info">
            <div class="appointment-card__info-date">
                <div>
                    <h3>Made On</h3>
                    <p>
                        2023/1/3
                    </p>
                </div>
            </div>
        </div>
        <div class="appointment-card__footer">
            <div><strong>
                    For:
                </strong>
                Aston Martin DB11
            </div>
            <div class="flex items-center gap-4">
                <button style="color: var(--color-info)">
                    View QR Code
                </button>

            </div>
        </div>
    </div>

</div>

<div class="pagination-container">
    <a class='pagination-item pagination-item--active' href='/dashboard/records?vehicle_id=123&page=1&limit=2'>1</a>
    <a class='pagination-item' href='/dashboard/records?vehicle_id=123&page=2&limit=2'>2</a>
    <a class='pagination-item' href='/dashboard/records?vehicle_id=123&page=3&limit=2'>3</a>
    <a class='pagination-item' href='/dashboard/records?vehicle_id=123&page=4&limit=2'>4</a>
    <a class='pagination-item' href='/dashboard/records?vehicle_id=123&page=5&limit=2'>5</a>
    <a class='pagination-item' href='/dashboard/records?vehicle_id=123&page=6&limit=2'>6</a>
</div> -->

<?php
/**
 * @var array $appointments
 */
?>

<?php 
        foreach($appointments as $appointment){            
            echo " <a class='appointment-card' href='/security-officer-dashboard/check-appointment'>Scan QR code
            <p class='appointment-card__name'>{$appointment['Name']}</p>
            <p class='appointment-card__regno'>{$appointment['RegNo']}</p>
            <p class='appointment-card__from_time'>{$appointment['FromTime']}</p>
            <p class='appointment-card__to_time'>{$appointment['ToTime']}</p>
            <p class='appointment-card__date'>{$appointment['Date']}</p>
            </a>";
        }
?>