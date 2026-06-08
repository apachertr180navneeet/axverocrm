    <!DOCTYPE html>
    <html>
        <head>
        <meta charset="utf-8">
            <title>Executive Report</title>
        
            <style>
            body { font-family: DejaVu Sans; font-size:12px; }
            h2 { text-align:center; margin-bottom:10px; }
            table { width:100%; border-collapse:collapse; margin-bottom:15px; }
            th, td { border:1px solid #000; padding:6px; }
            .section { margin-top:20px; }
            </style>
        </head>
    
    <body>
    
            <h2>Executive Report</h2>
            
            <table>
            <tr>
                <td><strong>Date</strong></td>
                <td>{{ \Carbon\Carbon::parse($report->report_date)->format('d/m/Y') }}</td>
            </tr>
            
            <tr>
                <td><strong>Portal Email</strong></td>
                <td>{{ $report->portal_email }}</td>
            </tr>
            
            <tr>
                <td><strong>Name</strong></td>
                <td>{{ $report->name }}</td>
            </tr>
            
            <tr>
                <td><strong>Mobile</strong></td>
                <td>{{ $report->mobile }}</td>
            </tr>
            
            <tr>
                <td><strong>HR Manager</strong></td>
                <td>{{ $report->hr_manager_name }}</td>
            </tr>
            
            <tr>
                <td><strong>HR Manager Mobile</strong></td>
                <td>{{ $report->hr_manager_mobile }}</td>
            </tr>
            
            </table>
            
            
            {{-- ================= Selected Persons ================= --}}
            <div class="section">
            <h4>Today Selected Person's Report</h4>
            
            <table>
            
            <tr>
            <th>Name</th>
            <th>Mobile</th>
            <th>Designation</th>
            <th>Joining Date</th>
            <th>Email</th>
            </tr>
            
            @forelse($selectedPersons ?? [] as $person)
            
            <tr>
            <td>{{ $person['name'] ?? '' }}</td>
            
            <td>{{ $person['mobile'] ?? '' }}</td>
            
            <td>{{ $person['designation'] ?? '' }}</td>
            
            <td>
            @if(!empty($person['joining_date']))
            {{ \Carbon\Carbon::parse($person['joining_date'])->format('d/m/Y') }}
            @endif
            </td>
            
            <td>{{ $person['email'] ?? '' }}</td>
            </tr>
            
            @empty
            
            <tr>
            <td colspan="5" style="text-align:center;">No Data Available</td>
            </tr>
            
            @endforelse
            
            </table>
            
            </div>
            
            
            {{-- ================= Follow Up ================= --}}
            <div class="section">
            
            <h4>Follow Up Candidates Detail</h4>
            
            <table>
            
            <tr>
            <th>Name</th>
            <th>Mobile</th>
            <th>Interview Date</th>
            </tr>
            
            @forelse($followUp ?? [] as $person)
            
            <tr>
            <td>{{ $person['name'] ?? '' }}</td>
            
            <td>{{ $person['mobile'] ?? '' }}</td>
            
            <td>
            @if(!empty($person['interview_date']))
            {{ \Carbon\Carbon::parse($person['interview_date'])->format('d/m/Y') }}
            @endif
            </td>
            
            </tr>
            
            @empty
            
            <tr>
            <td colspan="3" style="text-align:center;">No Data Available</td>
            </tr>
            
            @endforelse
            
            </table>
            
            </div>
            
            
            {{-- ================= Total Joined ================= --}}
            <div class="section">
            
            <h4>Detail of Joined Total Candidate</h4>
            
            <table>
            
            <tr>
            <th>Total HR Executive</th>
            <th>Total Sales Executive</th>
            </tr>
            
            @forelse($totalJoined ?? [] as $total)
            
            <tr>
            <td>{{ $total['total_executive'] ?? '' }}</td>
            <td>{{ $total['total_sales_executive'] ?? '' }}</td>
            </tr>
            
            @empty
            
            <tr>
            <td colspan="2" style="text-align:center;">No Data Available</td>
            </tr>
            
            @endforelse
            
            </table>
            
            </div>
            
    </body>
    </html>