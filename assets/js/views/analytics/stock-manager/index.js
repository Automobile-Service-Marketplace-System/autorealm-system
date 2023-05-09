import "./revenue-chart";
import "./order-quantity-chart";

import {
    Chart,
    PieController,
    LineController,
    ArcElement,
    LineElement,
    CategoryScale,
    LinearScale,
    PointElement,
    Tooltip, Legend, Filler,
} from 'chart.js';

import Zoom, {resetZoom} from 'chartjs-plugin-zoom';

import Notifier from "../../../components/Notifier";

Chart.register(
    PieController,
    LineController,
    ArcElement,
    PointElement,
    LineElement,
    CategoryScale,
    LinearScale,
    Tooltip,
    Legend,
    Filler,
    Zoom
)
