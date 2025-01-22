// user_model.dart
class UserModel {
  final int userID;
  final String name;
  final String email;
  final String? phone;
  final String? image;
  final String role;

  UserModel({
    required this.userID,
    required this.name,
    required this.email,
    this.phone,
    this.image,
    required this.role,
  });

  factory UserModel.fromJson(Map<String, dynamic> json) {
    return UserModel(
      userID: json['userID'],
      name: json['name'],
      email: json['email'],
      phone: json['phone'],
      image: json['image'],
      role: json['role'],
    );
  }
}