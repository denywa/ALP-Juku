import 'package:flutter/material.dart';

class PesananScreen extends StatelessWidget {
  const PesananScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Riwayat Pesanan'),
      ),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: const [
            Icon(Icons.receipt_long, size: 100),
            SizedBox(height: 20),
            Text(
              'Anda belum memiliki pesanan',
              style: TextStyle(fontSize: 18),
            ),
          ],
        ),
      ),
    );
  }
}
