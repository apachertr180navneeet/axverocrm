            <!DOCTYPE html>
            <html>
            <head>
            <meta charset="utf-8">
            <title>Report Manager PDF</title>
            
            <style>
            body{
            font-family: DejaVu Sans, sans-serif;
            font-size:12px;
            }
            
            h2{
            text-align:center;
            margin-bottom:10px;
            }
            
            table{
            width:100%;
            border-collapse:collapse;
            margin-bottom:15px;
            }
            
            table,th,td{
            border:1px solid #000;
            }
            
            th{
            background:#f2f2f2;
            }
            
            th,td{
            padding:6px;
            text-align:left;
            }
            
            .section-title{
            margin-top:20px;
            font-weight:bold;
            font-size:14px;
            }
            </style>
            </head>
            
            <body>
            
            <h2>Report Manager</h2>
            
            <table>
            <tr>
            <th>Date</th>
            <td>{{ $report->report_date }}</td>
            </tr>
            
            <tr>
            <th>Email</th>
            <td>{{ $report->portal_email }}</td>
            </tr>
            
            <tr>
            <th>Name</th>
            <td>{{ $report->name }}</td>
            </tr>
            
            <tr>
            <th>Mobile</th>
            <td>{{ $report->mobile }}</td>
            </tr>
            
            {{-- Removed from form but NOT deleted --}}
            {{--
            <tr>
            <th>Total Joined Retainer</th>
            <td>{{ $report->total_joined_retainer }}</td>
            </tr>
            --}}
            </table>
            
            
            
            {{-- ================= Selected Persons ================= --}}
            <div class="section-title">Today Selected Person Detail</div>
            
            <table>
            
            <thead>
            <tr>
            <th>HR Executive Name</th>
            <th>HR Mobile</th>
            <th>Name</th>
            <th>Person Mobile</th>
            <th>Salary</th>
            <th>Email</th>
            <th>Designation</th>
            <th>Joining Date</th>
            </tr>
            </thead>
            
            <tbody>
            
            @forelse($selectedPersons as $row)
            
            <tr>
            <td>{{ $row['hr_name'] ?? '' }}</td>
            <td>{{ $row['hr_mobile'] ?? '' }}</td>
            <td>{{ $row['selected_name'] ?? '' }}</td>
            <td>{{ $row['selected_mobile'] ?? '' }}</td>
            
            <td>{{ $row['salary_offered'] ?? '' }}</td>
            <td>{{ $row['person_email'] ?? '' }}</td>
            
            <td>{{ $row['designation'] ?? '' }}</td>
            <td>{{ $row['joining_date'] ?? '' }}</td>
            
            </tr>
            
            @empty
            
            <tr>
            <td colspan="8">No Data</td>
            </tr>
            
            @endforelse
            
            </tbody>
            </table>
            
            
            
            {{-- ================= Retainers ================= --}}
            {{-- Removed in form but NOT deleted --}}
            
            {{--
            
            <div class="section-title">Retainers</div>
            
            <table>
            
            <thead>
            <tr>
            <th>HR Name</th>
            <th>HR Mobile</th>
            <th>Retainer Name</th>
            <th>Retainer Mobile</th>
            </tr>
            </thead>
            
            <tbody>
            
            @forelse($retainers as $row)
            
            <tr>
            <td>{{ $row['hr_name'] ?? '' }}</td>
            <td>{{ $row['hr_mobile'] ?? '' }}</td>
            <td>{{ $row['retainer_name'] ?? '' }}</td>
            <td>{{ $row['retainer_mobile'] ?? '' }}</td>
            </tr>
            
            @empty
            
            <tr>
            <td colspan="4">No Data</td>
            </tr>
            
            @endforelse
            
            </tbody>
            </table>
            
            --}}
            
            
            
            {{-- ================= Team Details ================= --}}
            
            <div class="section-title">Total Team Detail</div>
            
            <table>
            
            <thead>
            <tr>
            <th>HR Executive Name</th>
            <th>HR Mobile</th>
            <th>Total HR Executive</th>
            <th>Total Sales Executive</th>
            </tr>
            </thead>
            
            <tbody>
            
            @forelse($teamDetails as $row)
            
            <tr>
            
            <td>{{ $row['hr_name'] ?? '' }}</td>
            <td>{{ $row['hr_mobile'] ?? '' }}</td>
            <td>{{ $row['total_active_executive'] ?? '' }}</td>
            <td>{{ $row['total_active_retainer'] ?? '' }}</td>
            
            </tr>
            
            @empty
            
            <tr>
            <td colspan="4">No Data</td>
            </tr>
            
            @endforelse
            
            </tbody>
            
            </table>
            
            </body>
            </html>