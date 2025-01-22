import 'package:apk/detail_pesanan.dart';
import 'package:apk/detail_riwayat.dart';
import 'package:flutter/material.dart';
import 'login_screen.dart';
import 'dashboard_screen.dart';
import 'splash_screen.dart';
import 'menu_screen.dart' as Menu;
import 'keranjang_screen.dart';
import 'pesanan_screen.dart' as Pesanan;
import 'info.dart';
import 'riwayat.dart';
import 'profil_tambak.dart';
import 'editprofil_tambak.dart';
import 'detail_pesanan.dart';
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
      home: DashboardScreen(), // Remove 'const' here
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
        '/profilTambakPage': (context) => ProfilTambakPage(),
        '/editprofilTambakPage': (context) => EditProfilTambakPage(),
        '/detailriwayat': (context) => DetailRiwayatPage(
              item: ModalRoute.of(context)!.settings.arguments
                  as Map<String, dynamic>,
            ),
      },
    );
  }
}
