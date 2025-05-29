@extends('admin.dashboard')

@section('content')
<div class="reports-container">
    <div class="page-header">
        <div class="header-content">
            <h1><i class='bx bx-chart'></i> Reports & Analytics</h1>
            <div class="header-actions">
                <div class="date-filter">
                    <select id="dateRange" onchange="updateReports()">
                        <option value="7">Last 7 Days</option>
                        <option value="30" selected>Last 30 Days</option>
                        <option value="90">Last 3 Months</option>
                        <option value="365">Last Year</option>
                    </select>
                </div>
                <button class="export-btn" onclick="exportReports()">
                    <i class='bx bx-export'></i> Export Data
                </button>
            </div>
        </div>
    </div>

    <!-- Overview Cards -->
    <div class="overview-section">
        <div class="overview-card revenue">
            <div class="card-icon">
                <i class='bx bx-money'></i>
            </div>
            <div class="card-content">
                <h3>Total Revenue</h3>
                <p class="number">₱{{ number_format($totalRevenue, 2) }}</p>
                <span class="trend {{ $revenueTrend >= 0 ? 'positive' : 'negative' }}">
                    <i class='bx {{ $revenueTrend >= 0 ? "bx-up-arrow-alt" : "bx-down-arrow-alt" }}'></i>
                    {{ abs($revenueTrend) }}% from last period
                </span>
            </div>
        </div>

        <div class="overview-card transactions">
            <div class="card-icon">
                <i class='bx bx-transfer'></i>
            </div>
            <div class="card-content">
                <h3>Total Transactions</h3>
                <p class="number">{{ $totalTransactions }}</p>
                <span class="trend {{ $transactionsTrend >= 0 ? 'positive' : 'negative' }}">
                    <i class='bx {{ $transactionsTrend >= 0 ? "bx-up-arrow-alt" : "bx-down-arrow-alt" }}'></i>
                    {{ abs($transactionsTrend) }}% from last period
                </span>
            </div>
        </div>

        <div class="overview-card occupancy">
            <div class="card-icon">
                <i class='bx bx-home-alt'></i>
            </div>
            <div class="card-content">
                <h3>Occupancy Rate</h3>
                <p class="number">{{ $occupancyRate }}%</p>
                <span class="trend {{ $occupancyTrend >= 0 ? 'positive' : 'negative' }}">
                    <i class='bx {{ $occupancyTrend >= 0 ? "bx-up-arrow-alt" : "bx-down-arrow-alt" }}'></i>
                    {{ abs($occupancyTrend) }}% from last period
                </span>
            </div>
        </div>

        <div class="overview-card applications">
            <div class="card-icon">
                <i class='bx bx-file'></i>
            </div>
            <div class="card-content">
                <h3>New Applications</h3>
                <p class="number">{{ $newApplications }}</p>
                <span class="trend {{ $applicationsTrend >= 0 ? 'positive' : 'negative' }}">
                    <i class='bx {{ $applicationsTrend >= 0 ? "bx-up-arrow-alt" : "bx-down-arrow-alt" }}'></i>
                    {{ abs($applicationsTrend) }}% from last period
                </span>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-grid">
        <!-- Revenue Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <h2>Revenue Overview</h2>
                <div class="chart-actions">
                    <button class="chart-tab active" onclick="updateRevenueChart('monthly')">Monthly</button>
                    <button class="chart-tab" onclick="updateRevenueChart('weekly')">Weekly</button>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Property Performance -->
        <div class="chart-card">
            <div class="chart-header">
                <h2>Property Performance</h2>
                <div class="chart-actions">
                    <button class="chart-tab active" onclick="updatePropertyChart('occupancy')">Occupancy</button>
                    <button class="chart-tab" onclick="updatePropertyChart('revenue')">Revenue</button>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="propertyChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Detailed Reports Section -->
    <div class="reports-grid">
        <!-- Transaction History -->
        <div class="report-card">
            <div class="report-header">
                <h2><i class='bx bx-history'></i> Recent Transactions</h2>
                <a href="#" class="view-all">View All</a>
            </div>
            <div class="transaction-list">
                @forelse($recentTransactions as $transaction)
                    <div class="transaction-item">
                        <div class="transaction-info">
                            <div class="tenant-details">
                                <span class="tenant-name">{{ $transaction->tenant->name }}</span>
                                <span class="property-address">{{ $transaction->rental->address }}</span>
                            </div>
                            <div class="transaction-amount">
                                <span class="amount">₱{{ number_format($transaction->total_amount, 2) }}</span>
                                <span class="date">{{ $transaction->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                        <div class="transaction-status {{ $transaction->status }}">
                            {{ ucfirst($transaction->status) }}
                        </div>
                    </div>
                @empty
                    <div class="no-data">No recent transactions</div>
                @endforelse
            </div>
        </div>

        <!-- Top Performing Properties -->
        <div class="report-card">
            <div class="report-header">
                <h2><i class='bx bx-building-house'></i> Top Properties</h2>
                <a href="#" class="view-all">View All</a>
            </div>
            <div class="properties-list">
                @forelse($topProperties as $property)
                    <div class="property-item">
                        <div class="property-info">
                            <div class="property-details">
                                <span class="address">{{ $property->address }}</span>
                                <span class="type">{{ ucfirst($property->house_type) }}</span>
                            </div>
                            <div class="property-stats">
                                <span class="occupancy">{{ $property->occupancy_rate }}% Occupied</span>
                                <span class="revenue">₱{{ number_format($property->total_revenue, 2) }}</span>
                            </div>
                        </div>
                        <div class="trend-indicator {{ $property->trend >= 0 ? 'positive' : 'negative' }}">
                            <i class='bx {{ $property->trend >= 0 ? "bx-up-arrow-alt" : "bx-down-arrow-alt" }}'></i>
                            {{ abs($property->trend) }}%
                        </div>
                    </div>
                @empty
                    <div class="no-data">No property data available</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
.reports-container {
    padding: 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

.page-header {
    margin-bottom: 2rem;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-content h1 {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.5rem;
    color: #2d3748;
    margin: 0;
}

.header-actions {
    display: flex;
    gap: 1rem;
}

.date-filter select {
    padding: 0.5rem 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    background: white;
    color: #4a5568;
}

.export-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: #4299e1;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.export-btn:hover {
    background: #3182ce;
}

/* Overview Cards */
.overview-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.overview-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    display: flex;
    gap: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.card-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card-icon i {
    font-size: 1.5rem;
    color: white;
}

.revenue .card-icon {
    background: linear-gradient(135deg, #4299e1, #3182ce);
}

.transactions .card-icon {
    background: linear-gradient(135deg, #48bb78, #38a169);
}

.occupancy .card-icon {
    background: linear-gradient(135deg, #ed8936, #dd6b20);
}

.applications .card-icon {
    background: linear-gradient(135deg, #667eea, #5a67d8);
}

.card-content h3 {
    font-size: 0.875rem;
    color: #718096;
    margin: 0 0 0.5rem 0;
}

.card-content .number {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
    margin: 0 0 0.5rem 0;
}

.trend {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.875rem;
}

.trend.positive {
    color: #38a169;
}

.trend.negative {
    color: #e53e3e;
}

/* Charts Grid */
.charts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.chart-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.chart-header h2 {
    font-size: 1.25rem;
    color: #2d3748;
    margin: 0;
}

.chart-actions {
    display: flex;
    gap: 0.5rem;
}

.chart-tab {
    padding: 0.5rem 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    background: white;
    color: #4a5568;
    cursor: pointer;
}

.chart-tab.active {
    background: #ebf8ff;
    color: #2b6cb0;
    border-color: #90cdf4;
}

/* Reports Grid */
.reports-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
}

.report-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.report-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.report-header h2 {
    font-size: 1.25rem;
    color: #2d3748;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.view-all {
    color: #4299e1;
    text-decoration: none;
    font-size: 0.875rem;
}

/* Transaction List */
.transaction-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.transaction-item {
    padding: 1rem;
    background: #f7fafc;
    border-radius: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.transaction-info {
    display: flex;
    justify-content: space-between;
    flex: 1;
    margin-right: 1rem;
}

.tenant-details {
    display: flex;
    flex-direction: column;
}

.tenant-name {
    font-weight: 500;
    color: #2d3748;
}

.property-address {
    font-size: 0.875rem;
    color: #718096;
}

.transaction-amount {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
}

.amount {
    font-weight: 500;
    color: #2d3748;
}

.date {
    font-size: 0.875rem;
    color: #718096;
}

.transaction-status {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
}

.transaction-status.completed {
    background: #def7ec;
    color: #03543f;
}

.transaction-status.pending {
    background: #fef3c7;
    color: #92400e;
}

.transaction-status.cancelled {
    background: #fee2e2;
    color: #991b1b;
}

/* Properties List */
.properties-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.property-item {
    padding: 1rem;
    background: #f7fafc;
    border-radius: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.property-info {
    display: flex;
    justify-content: space-between;
    flex: 1;
    margin-right: 1rem;
}

.property-details {
    display: flex;
    flex-direction: column;
}

.address {
    font-weight: 500;
    color: #2d3748;
}

.type {
    font-size: 0.875rem;
    color: #718096;
}

.property-stats {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
}

.occupancy {
    font-weight: 500;
    color: #2d3748;
}

.revenue {
    font-size: 0.875rem;
    color: #718096;
}

.trend-indicator {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-weight: 500;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
}

.trend-indicator.positive {
    background: #def7ec;
    color: #03543f;
}

.trend-indicator.negative {
    background: #fee2e2;
    color: #991b1b;
}

.no-data {
    text-align: center;
    padding: 2rem;
    color: #a0aec0;
    background: #f7fafc;
    border-radius: 8px;
}

@media (max-width: 768px) {
    .reports-container {
        padding: 1rem;
    }

    .header-content {
        flex-direction: column;
        gap: 1rem;
    }

    .header-actions {
        width: 100%;
        flex-direction: column;
    }

    .charts-grid,
    .reports-grid {
        grid-template-columns: 1fr;
    }

    .transaction-item,
    .property-item {
        flex-direction: column;
        gap: 1rem;
    }

    .transaction-info,
    .property-info {
        flex-direction: column;
        gap: 0.5rem;
        margin-right: 0;
    }

    .transaction-amount,
    .property-stats {
        align-items: flex-start;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Initialize charts when the page loads
document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
});

function initializeCharts() {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($revenueChartLabels) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($revenueChartData) !!},
                borderColor: '#4299e1',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Property Chart
    const propertyCtx = document.getElementById('propertyChart').getContext('2d');
    new Chart(propertyCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($propertyChartLabels) !!},
            datasets: [{
                label: 'Occupancy Rate',
                data: {!! json_encode($propertyChartData) !!},
                backgroundColor: '#48bb78'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}

function updateReports() {
    const dateRange = document.getElementById('dateRange').value;
    // Implement AJAX call to update report data
}

function updateRevenueChart(period) {
    // Implement chart update logic
}

function updatePropertyChart(metric) {
    // Implement chart update logic
}

function exportReports() {
    // Implement export functionality
}
</script>
@endsection 