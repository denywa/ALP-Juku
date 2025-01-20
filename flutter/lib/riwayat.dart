import 'package:flutter/material.dart';
import 'package:apk/main.dart'; // Pastikan ini sesuai dengan path file utama Anda

void main() {
  runApp(const MyApp());
}

class RiwayatScreen extends StatelessWidget {
  const RiwayatScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Riwayat Akun'),
        backgroundColor: Colors.white,
        foregroundColor: Colors.black,
        elevation: 0,
        leading: IconButton(
          icon: const Icon(Icons.arrow_back),
          onPressed: () {
            Navigator.pop(context); // Kembali ke MenuScreen
          },
        ),
      ),
      body: AccountHistoryScreen(),
    );
  }
}

class AccountHistoryScreen extends StatelessWidget {
  final List<Map<String, dynamic>> accountActivity = [
    {
      'dateLabel': 'Kemarin',
      'activities': [
        {
          'description': 'Tambak A - Tamalanrea',
          'amount': 'Rp75.000',
          'time': '12 Nov 2024, 16:00',
        },
        {
          'description': 'Tambak A - Tamalanrea',
          'amount': 'Rp65.000',
          'time': '12 Nov 2024, 13:00',
        },
        {
          'description': 'Tambak A - Tamalanrea',
          'amount': 'Rp55.000',
          'time': '12 Nov 2024, 12:30',
        },
      ],
    },
    {
      'dateLabel': '10 November',
      'activities': [
        {
          'description': 'Tambak A - Tamalanrea',
          'amount': 'Rp25.000',
          'time': '10 Nov 2024, 16:00',
        },
        {
          'description': 'Tambak A - Tamalanrea',
          'amount': 'Rp70.000',
          'time': '10 Nov 2024, 10:34',
        },
      ],
    },
  ];

  @override
  Widget build(BuildContext context) {
    return ListView.builder(
      itemCount: accountActivity.length,
      itemBuilder: (context, index) {
        final activityItem = accountActivity[index];
        return Padding(
          padding: const EdgeInsets.symmetric(vertical: 16.0, horizontal: 16.0), // Add more vertical spacing
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                activityItem['dateLabel'],
                style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
              ),
              const SizedBox(height: 16), // Add spacing between the lists
              ...List.generate(activityItem['activities'].length, (activityIndex) {
                final activity = activityItem['activities'][activityIndex];
                return Padding(
                  padding: const EdgeInsets.symmetric(vertical: 16.0),
                  child: Row(
                    children: [
                      const CircleAvatar(
                        backgroundImage: AssetImage('assets/logo.png'), // Replace with your image path
                        radius: 24,
                      ),
                      const SizedBox(width: 12),
                      Expanded(
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              activity['description'],
                              style: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
                            ),
                            const SizedBox(height: 4),
                            Text(
                              activity['time'],
                              style: const TextStyle(color: Colors.grey),
                            ),
                          ],
                        ),
                      ),
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.end,
                        children: [
                          Text(
                            activity['amount'],
                            style: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
                          ),
                          const SizedBox(height: 4),
                          TextButton(
                            onPressed: () {
                              showDialog(
                                context: context,
                                builder: (BuildContext context) {
                                  return RatingDialog();
                                },
                              );
                            },
                            style: TextButton.styleFrom(
                              padding: EdgeInsets.zero,
                              minimumSize: Size.zero,
                              tapTargetSize: MaterialTapTargetSize.shrinkWrap,
                            ),
                            child: const Text(
                              'Beri Rating Disini',
                              style: TextStyle(color: Colors.blue, fontSize: 14),
                            ),
                          ),
                        ],
                      ),
                    ],
                  ),
                );
              }),
            ],
          ),
        );
      },
    );
  }
}

class RatingDialog extends StatefulWidget {
  @override
  _RatingDialogState createState() => _RatingDialogState();
}

class _RatingDialogState extends State<RatingDialog> {
  int _hoveredRating = 0;
  int _selectedRating = 0;

  @override
  Widget build(BuildContext context) {
    return Dialog(
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(16.0),
      ),
      child: Stack(
        children: [
          Padding(
            padding: const EdgeInsets.all(16.0),
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: [
                const SizedBox(height: 40),
                const Text(
                  'Beri Rating',
                  style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
                ),
                const SizedBox(height: 16),
                Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: List.generate(5, (index) {
                    return Padding(
                      padding: const EdgeInsets.symmetric(horizontal: 8.0),
                      child: MouseRegion(
                        onEnter: (_) {
                          setState(() {
                            _hoveredRating = index + 1;
                          });
                        },
                        onExit: (_) {
                          setState(() {
                            _hoveredRating = 0;
                          });
                        },
                        child: GestureDetector(
                          onTap: () {
                            setState(() {
                              _selectedRating = index + 1;
                            });
                          },
                          child: Icon(
                            Icons.star,
                            size: 36, // Make the stars bigger
                            color: index < (_hoveredRating > 0 ? _hoveredRating : _selectedRating)
                                ? Colors.amber
                                : Colors.grey,
                          ),
                        ),
                      ),
                    );
                  }),
                ),
                const SizedBox(height: 24),
                Align(
                  alignment: Alignment.centerRight,
                  child: TextButton(
                    onPressed: () {
                      Navigator.of(context).pop();
                      // Here you can save the rating or perform other actions
                    },
                    child: const Text(
                      'Simpan',
                      style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
                    ),
                  ),
                ),
              ],
            ),
          ),
          Positioned(
            top: 8,
            left: 8,
            child: GestureDetector(
              onTap: () {
                Navigator.of(context).pop();
              },
              child: const Icon(
                Icons.close,
                size: 24,
                color: Colors.black,
              ),
            ),
          ),
        ],
      ),
    );
  }
}
