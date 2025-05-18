                                    <tr>
                                        <th>Nama</th>
                                        <th>Program</th>
                                        <th>Orang Tua</th>
                                        <th>Tanggal Bergabung</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($latestStudents as $student)
                                    <tr>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->program }}</td>
                                        <td>{{ $student->parent ? $student->parent->name : '-' }}</td>
                                        <td>{{ $student->created_at->format('d M Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody> 