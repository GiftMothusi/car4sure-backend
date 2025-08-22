<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Policy Certificate - {{ $policy->policy_no }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
        }
        .document-title {
            font-size: 18px;
            margin-top: 10px;
            font-weight: bold;
        }
        .policy-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .row {
            display: flex;
            margin-bottom: 8px;
        }
        .label {
            font-weight: bold;
            width: 150px;
            display: inline-block;
        }
        .value {
            flex: 1;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-active { background-color: #d1fae5; color: #065f46; }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-inactive { background-color: #fee2e2; color: #991b1b; }
        .status-cancelled { background-color: #f3f4f6; color: #374151; }
        .status-expired { background-color: #fca5a5; color: #7f1d1d; }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">Car4Sure Insurance</div>
        <div class="document-title">INSURANCE POLICY CERTIFICATE</div>
    </div>

    <div class="policy-info">
        <div class="row">
            <span class="label">Policy Number:</span>
            <span class="value"><strong>{{ $policy->policy_no }}</strong></span>
        </div>
        <div class="row">
            <span class="label">Policy Status:</span>
            <span class="value">
                <span class="status-badge status-{{ strtolower($policy->policy_status) }}">
                    {{ $policy->policy_status }}
                </span>
            </span>
        </div>
        <div class="row">
            <span class="label">Policy Type:</span>
            <span class="value">{{ $policy->policy_type }}</span>
        </div>
        <div class="row">
            <span class="label">Effective Date:</span>
            <span class="value">{{ $policy->policy_effective_date->format('F j, Y') }}</span>
        </div>
        <div class="row">
            <span class="label">Expiration Date:</span>
            <span class="value">{{ $policy->policy_expiration_date->format('F j, Y') }}</span>
        </div>
    </div>

    <div class="section">
        <div class="section-title">POLICY HOLDER INFORMATION</div>
        <div class="row">
            <span class="label">Name:</span>
            <span class="value">{{ $policy->policy_holder['firstName'] }} {{ $policy->policy_holder['lastName'] }}</span>
        </div>
        <div class="row">
            <span class="label">Address:</span>
            <span class="value">
                {{ $policy->policy_holder['address']['street'] }}<br>
                {{ $policy->policy_holder['address']['city'] }}, {{ $policy->policy_holder['address']['state'] }} {{ $policy->policy_holder['address']['zip'] }}
            </span>
        </div>
    </div>

    <div class="section">
        <div class="section-title">DRIVERS INFORMATION</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>License Number</th>
                    <th>License State</th>
                    <th>License Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($policy->drivers as $driver)
                <tr>
                    <td>{{ $driver['firstName'] }} {{ $driver['lastName'] }}</td>
                    <td>{{ $driver['age'] }}</td>
                    <td>{{ $driver['gender'] }}</td>
                    <td>{{ $driver['licenseNumber'] }}</td>
                    <td>{{ $driver['licenseState'] }}</td>
                    <td>{{ $driver['licenseStatus'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">VEHICLES INFORMATION</div>
        @foreach($policy->vehicles as $index => $vehicle)
        <div style="margin-bottom: 20px; page-break-inside: avoid;">
            <h4>Vehicle {{ $index + 1 }}</h4>
            <div class="row">
                <span class="label">Year/Make/Model:</span>
                <span class="value">{{ $vehicle['year'] }} {{ $vehicle['make'] }} {{ $vehicle['model'] }}</span>
            </div>
            <div class="row">
                <span class="label">VIN:</span>
                <span class="value">{{ $vehicle['vin'] }}</span>
            </div>
            <div class="row">
                <span class="label">Usage:</span>
                <span class="value">{{ $vehicle['usage'] }}</span>
            </div>
            <div class="row">
                <span class="label">Annual Mileage:</span>
                <span class="value">{{ number_format($vehicle['annualMileage']) }} miles</span>
            </div>
            <div class="row">
                <span class="label">Ownership:</span>
                <span class="value">{{ $vehicle['ownership'] }}</span>
            </div>
            <div class="row">
                <span class="label">Garaging Address:</span>
                <span class="value">
                    {{ $vehicle['garagingAddress']['street'] }}<br>
                    {{ $vehicle['garagingAddress']['city'] }}, {{ $vehicle['garagingAddress']['state'] }} {{ $vehicle['garagingAddress']['zip'] }}
                </span>
            </div>
            
            <table class="table" style="margin-top: 10px;">
                <thead>
                    <tr>
                        <th>Coverage Type</th>
                        <th>Limit</th>
                        <th>Deductible</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicle['coverages'] as $coverage)
                    <tr>
                        <td>{{ $coverage['type'] }}</td>
                        <td>R{{ number_format($coverage['limit']) }}</td>
                        <td>R{{ number_format($coverage['deductible']) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach
    </div>

    <div class="footer">
        <p>This certificate is issued as a matter of information only and confers no rights upon the certificate holder.</p>
        <p>This certificate does not affirmatively or negatively amend, extend, or alter the coverage afforded by the policies listed herein.</p>
        <p><strong>Generated on:</strong> {{ $generatedAt }}</p>
    </div>
</body>
</html>