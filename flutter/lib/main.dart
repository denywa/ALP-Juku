import 'package:flutter/material.dart';
import 'login_screen.dart';
import 'dashboard_screen.dart';
import 'splash_screen.dart';
import 'menu_screen.dart' as Menu; // Menggunakan alias untuk menu_screen.dart
import 'keranjang_screen.dart'; // Impor KeranjangScreen
import 'pesanan_screen.dart' as Pesanan; // Menggunakan alias Pesanan
import 'info.dart'; // Import layar InformasiScreen
import 'riwayat.dart'; // Import layar RiwayatScreen
import 'theme/app_theme.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Juku Sambalu',
      theme: AppTheme.lightTheme,
      debugShowCheckedModeBanner: false,

      home: SplashScreen(), // Remove 'const' here
      routes: {
        '/login': (context) => const LoginScreen(),
        '/dashboard': (context) => const DashboardScreen(),
        '/menu': (context) => Menu.MenuScreen(), // Menggunakan alias Menu
        '/keranjang': (context) =>
            KeranjangScreen(), // Tambahkan rute untuk KeranjangScreen
        '/pesanan': (context) =>
            Pesanan.PesananScreen(), // Menggunakan alias Pesanan
        '/informasi': (context) =>
            const InformasiScreen(), // Rute untuk InformasiScreen
        '/riwayat': (context) =>
            const RiwayatScreen(), // Rute untuk RiwayatScreen
      },
    );
  }
}
