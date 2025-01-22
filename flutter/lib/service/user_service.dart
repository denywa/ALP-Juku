// user_service.dart
import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'user_model.dart'; // Import the UserModel class
import 'dart:io';

class UserService {
  final String baseUrl = "http://192.168.152.149:8000/api";

  Future<UserModel?> getCurrentUser() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      final token = prefs.getString('access_token');

      if (token == null) {
        return null;
      }

      final response = await http.get(
        Uri.parse('$baseUrl/users/me'),
        headers: {
          'Authorization': 'Bearer $token',
          'Accept': 'application/json',
        },
      );

      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        return UserModel.fromJson(data['data']);
      }
      return null;
    } catch (e) {
      print('Error getting user: $e');
      return null;
    }
  }

  Future<String?> uploadImage(File imageFile) async {
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('access_token');

    if (token == null) {
      return null;
    }

    var request = http.MultipartRequest(
      'POST',
      Uri.parse('$baseUrl/users/upload-image'),
    );
    request.headers.addAll({
      'Authorization': 'Bearer $token',
      'Accept': 'application/json',
    });
    request.files.add(await http.MultipartFile.fromPath(
      'image',
      imageFile.path,
    ));

    try {
      var response = await request.send();
      var responseData = await response.stream.bytesToString();
      var jsonData = json.decode(responseData);

      if (response.statusCode == 200) {
        return jsonData['data']['image_url']; // Adjust based on API response
      } else {
        print('Image upload failed: ${response.reasonPhrase}');
        return null;
      }
    } catch (e) {
      print('Error uploading image: $e');
      return null;
    }
  }

  Future<UserModel?> updateUser(
      int userId, String name, String? phone, String email) async {
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('access_token');

    if (token == null) {
      return null;
    }

    final response = await http.put(
      Uri.parse('$baseUrl/users/$userId'),
      headers: {
        'Authorization': 'Bearer $token',
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
      body: json.encode({
        'name': name,
        'phone': phone,
        'email': email,
      }),
    );

    if (response.statusCode == 200) {
      final data = json.decode(response.body);
      return UserModel.fromJson(data['data']);
    } else {
      print('Failed to update user: ${response.body}');
      return null;
    }
  }
}
