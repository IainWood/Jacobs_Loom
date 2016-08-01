package loginpage;

import java.io.IOException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.text.DecimalFormat;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.ComboBox;
import javafx.scene.control.Label;
import javafx.scene.control.TextField;
import javafx.scene.image.Image;
import javafx.scene.layout.Pane;
import javafx.stage.Stage;

/**
 * @author Iain Woodburn
 */
public class EmployeeInfoController {
    
    @FXML private Label balanceAmount;
    @FXML private Label name;
    @FXML private Label email;
    @FXML private Label phone;
    @FXML private Label street1;
    @FXML private Label street2;
    @FXML private Label city_state_zip;
    @FXML private Pane deposit_pane;
    @FXML private Pane pickup_pane;
    @FXML private TextField amountToDeposit;
    @FXML private TextField confirmAmount;
    @FXML private Label errorLabelDeposit;
    @FXML private ComboBox product_menu;
    @FXML private ComboBox primary_color_menu;
    @FXML private ComboBox secondary_color_menu;
    @FXML private ComboBox type_menu;
    @FXML private Label required_1;
    @FXML private Label required_2;
    @FXML private Label required_3;
    @FXML private Label error_pickup;
    @FXML private TextField num_of_products;
    //For mySQL
    Connection myConn;
    Statement myStatement;
    ResultSet myRs;
    private static final String URL = "jdbc:mysql://localhost:3306/new_schema?autoReconnect=true&useSSL=false";
    private static final String USERNAME = "root";
    private static final String PASSWORD = "J@c0bsl0om";
    
    /**
     * Initializes the employee's info from the card that was swiped on the previous window
     */
    @FXML
    private void initialize(){   
        
        DecimalFormat df = new DecimalFormat("#.00");
        
        String emp_id = "'".concat("1".concat("'"));
        String emp_first_name = "";
        String emp_last_name = "";
        String emp_balance = "";
        String emp_email = "";
        String emp_phone = "";
        String emp_street_address1 = "";
        String emp_street_address2 = "";
        String emp_city = "";
        String emp_state = "";
        String emp_zip = "";
        
        try {

            //Opens a connection with the database
            getConnectionToDB();
            
            //Gets specific username from database
            myRs = myStatement.executeQuery("SELECT * FROM employees WHERE emp_id=" + emp_id);
            
            //Retrieves the information of the given user
            while(myRs.next()){
                emp_first_name = myRs.getString("emp_first_name");
                emp_last_name = myRs.getString("emp_last_name");
                emp_balance = myRs.getString("emp_balance");
                emp_email = myRs.getString("emp_email");
                emp_phone = myRs.getString("emp_phone");
                emp_street_address1 = myRs.getString("emp_street_address1");
                emp_street_address2 = myRs.getString("emp_street_address2");
                emp_city = myRs.getString("emp_city");
                emp_state = myRs.getString("emp_state");
                emp_zip = myRs.getString("emp_zip");
            }
            
            //Sets the labels to the correct values
            name.setText(emp_first_name + " " + emp_last_name);
            balanceAmount.setText("Current Balance: $" + df.format(Double.valueOf(emp_balance)));
            email.setText("Email: " + emp_email);
            phone.setText("Phone: " + emp_phone);
            street1.setText("Address: " + emp_street_address1);
            street2.setText(emp_street_address2);
            city_state_zip.setText(emp_city + " " + emp_state + " " + emp_zip);
            
        } catch (SQLException ex) {
            Logger.getLogger(LoginPage.class.getName()).log(Level.SEVERE, null, ex);
        }
        
    } //end initialize
    
    /**
     * Sets the visibility of the combo boxes depending on the value of the type menu
     * @param evt - When the type menu is activated
     */
    @FXML
    private void swapComboBoxes(ActionEvent evt){
        
        String productType = product_menu.getValue().toString();
        
        switch(productType){
            
            case "Headband":
                ObservableList<String> headbandPrimaryColors = FXCollections.observableArrayList(
                "Honolulu","Fort Worth Blue","Green Bay Green","Tampa Spice","Chicago Charcoal",
                "Dallas Grey","New York White","Oakland Black","Cincinatti Red","Misc");
                
                ObservableList<String> headbandSecondaryColors = FXCollections.observableArrayList(
                "New York White","Dallas Grey","Tampa Spice","Detroit Blue","Portland Wine",
                "Pittsburgh Pumpkin","Las Vegas Gold","(No Color)");
        
                ObservableList<String> typesHeadband = FXCollections.observableArrayList("Retail HB","Wholesale HB","Misc","In Progress Misc");
                
                primary_color_menu.setItems(headbandPrimaryColors);
                secondary_color_menu.setItems(headbandSecondaryColors);
                type_menu.setItems(typesHeadband);
                
                required_1.setVisible(true);
                primary_color_menu.setVisible(true);
                //No secondary color, set to default non value
                secondary_color_menu.setValue("(No Color)");
                required_2.setVisible(true);
                secondary_color_menu.setVisible(true);
                required_3.setVisible(true);
                type_menu.setVisible(true);
                break;
            case "Scarf":
                ObservableList<String> scarfPrimaryColors = FXCollections.observableArrayList(
                "Real Teal","Dark Orchid","Coral","Buff","Royal","Heather Grey",
                "Charcoal","Medium Thyme","Warm Brown","Shocking Pink","Delft Blue","Gold","Carrott","Orchid");
                
                ObservableList<String> scarfSecondaryColors = FXCollections.observableArrayList("Gold","(No Color)");
                
                ObservableList<String> typesScarf = FXCollections.observableArrayList("Retail S","Wholesale S");
                
                primary_color_menu.setItems(scarfPrimaryColors);
                secondary_color_menu.setItems(scarfSecondaryColors);
                type_menu.setItems(typesScarf);
                
                required_1.setVisible(true);
                primary_color_menu.setVisible(true);
                //No secondary color, set to default non value
                secondary_color_menu.setValue("(No Color)");
                required_2.setVisible(true);
                secondary_color_menu.setVisible(true);
                required_3.setVisible(true);
                type_menu.setVisible(true);
                break;
            case "Beanie":
                ObservableList<String> beaniePrimaryColors = FXCollections.observableArrayList(
                "Real Teal","Dark Orchid","Coral","Buff","Royal","Heather Grey","Charcoal",
                "Medium Thyme","Warm Brown","Shocking Pink","Delft Blue","Gold","Carrott","Orchid","Charcoal");
                
                ObservableList<String> beanieSecondaryColors = FXCollections.observableArrayList("Gold","(No Color)");
                
                ObservableList<String> typesBeanie = FXCollections.observableArrayList("Retail B","Wholesale B");
                
                primary_color_menu.setItems(beaniePrimaryColors);
                secondary_color_menu.setItems(beanieSecondaryColors);
                type_menu.setItems(typesBeanie);
                
                required_1.setVisible(true);
                primary_color_menu.setVisible(true);
                //No secondary color, set to default non value
                secondary_color_menu.setValue("(No Color)");
                required_2.setVisible(true);
                secondary_color_menu.setVisible(true);
                required_3.setVisible(true);
                type_menu.setVisible(true);
                break;
            case "Coffee Cozy":
                ObservableList<String> coffeeCozyColors = FXCollections.observableArrayList(
                "Real Teal","Shocking Pink","Gold","Carrott","Delft Blue",
                "Orchid","Medium Thyme","Charcoal","Warm Brown","Dark Orchid");
                
                ObservableList<String> typesCoffeeCozy = FXCollections.observableArrayList("Regular Label","Custom Label");
                
                primary_color_menu.setItems(coffeeCozyColors);
                type_menu.setItems(typesCoffeeCozy);
                
                required_1.setVisible(true);
                primary_color_menu.setVisible(true);
                //No secondary color, set to default non value
                secondary_color_menu.setValue("(No Color)");
                secondary_color_menu.setVisible(false);
                required_3.setVisible(true);
                type_menu.setVisible(true);
                break;
            default:
                
        } //end switch
        
    } //end swapComboBoxes
    
    /**
     * Adds items to the inventory when products are picked up
     * @param evt - When the Pickup button is pressed
     */
    @FXML
    private void addItemToInventory(ActionEvent evt){
        //Identifier for a product
        final String PRODUCT_IDENTIFIER = "003";
        if(product_menu.getValue() != null &&
                primary_color_menu.getValue() != null &&
                secondary_color_menu.getValue() != null &&
                type_menu.getValue() != null &&
                !num_of_products.getText().equals("")){
            String productType = product_menu.getValue().toString();
            String primaryColor = primary_color_menu.getValue().toString();
            String secondaryColor = secondary_color_menu.getValue().toString();
            String type = type_menu.getValue().toString();

            int productNum = getProductNum(productType);
            String primaryColorNum;
            String secondaryColorNum;
            //Same choices for everybody, so no need to switch
            String typeNum = getTypeNum(type);

            switch(productNum){

                case 1: //Headband
                    primaryColorNum = getHeadbandNum(primaryColor);
                    secondaryColorNum = getHeadbandNum(secondaryColor);
                    break;
                default: //If it's not a headband
                    primaryColorNum = getScarf_Beanie_CoffeeCozyNum(primaryColor);
                    secondaryColorNum = getScarf_Beanie_CoffeeCozyNum(secondaryColor);
            } //end switch

            if(!typeNum.equals("-1") &&
                    product_menu.getValue() != null &&
                    primary_color_menu.getValue() != null &&
                    secondary_color_menu.getValue() != null &&
                    type_menu.getValue() != null &&
                    num_of_products.getText() != null){
                
                try {
                    String IDNumber = PRODUCT_IDENTIFIER/*003*/ + "-" + primaryColorNum + "-" + secondaryColorNum + "-" + typeNum + "\t\tQuantity: " + num_of_products.getText();
                    System.out.println(IDNumber);
                    
                    getConnectionToDB();
                    //If the table does not exist, then it creates a new one
                    myStatement.executeUpdate("CREATE TABLE IF NOT EXISTS "+
                            "inventory(inv_id int(10) NOT NULL AUTO_INCREMENT,"+
                            "inv_identifier varchar(255) NOT NULL,"+
                            "inv_primaryColor varchar(255) NOT NULL,"+
                            "inv_secondaryColor varchar(255) NOT NULL,"+
                            "inv_type varchar(255) NOT NULL,"+
                            "inv_quantity_recieved varchar(255) NOT NULL,"+
                            "inv_assurance_id varchar(255) NOT NULL,"+
                            "PRIMARY KEY(inv_id))");
                    myStatement.executeUpdate("INSERT INTO inventory(inv_identifier, inv_primaryColor, inv_secondaryColor, inv_type, inv_quantity_recieved, inv_assurance_id)" +
                            "VALUES ('" + PRODUCT_IDENTIFIER + "', '" + primaryColorNum + "', '" + secondaryColorNum + "', '" + typeNum + "', '" + num_of_products.getText() + "', '" + "133" + "')");
                } catch (SQLException ex) {
                    Logger.getLogger(EmployeeInfoController.class.getName()).log(Level.SEVERE, null, ex);
                }
                
            }
            
        }else{
                error_pickup.setVisible(true);
        }  
        
    } //addItemToInventory
    
    /**
     * Gets a connection to the database
     */
    private void getConnectionToDB(){
        
        try {
            myConn = DriverManager.getConnection(URL, USERNAME , PASSWORD);
            //Creates a statement
            myStatement = myConn.createStatement();
        } catch (SQLException ex) {
            Logger.getLogger(LoginPage.class.getName()).log(Level.SEVERE, null, ex);
        }
        
    } //end getConnectionToDB
    
    /**
     * Gets the number version of the productType
     * @param productType - The value of the product_menu
     * @return the number corresponding to the productType, -1 if not found
     */
    private int getProductNum(String productType){
        
        switch(productType){
            
            case "Headband":
                return 1;
            case "Scarf":
                return 2;
            case "Beanie":
                return 3;
            case "Coffee Cozy":
                return 4;
            default:
                return -1;
        } //end switch
        
    } //end getProductNum
    
    /**
     * Gets the number version of the primary color of a headband
     * @param color - The name of the color
     * @return the number corresponding to the color, -1 if not found
     */
    private String getHeadbandNum(String color){
        
        switch(color){
            case "Honolulu":
                return "08";
            case "Fort Worth Blue":
                return "05";
            case "Green Bay Green":
                return "07";
            case "Tampa Spice":
                return "19";
            case "Chicago Charcoal":
                return "01";
            case "Dallas Grey":
                return "03";
            case "New York White":
                return "13";
            case "Oakland Black":
                return "14";
            case "Cincinatti Red":
                return "02";
            case "Detroit Blue":
                return "04";
            case "Portland Wine":
                return "16";
            case "Pittsburgh Pumpkin":
                return "17";
            case "Las Vegas Gold":
                return "10";
            case "Misc":
                return "00";
            default:
                return "00";
        }
        
    } //end getHeadbandNum
    
    /**
     * Gets the number version of a color of a scarf, beanie, or coffee cozy
     * @param color - The name of the color
     * @return the number corresponding to the color, -1 if not found
     */
    private String getScarf_Beanie_CoffeeCozyNum(String color){
        
        switch(color){
            case "Real Teal":
                return "11";
            case "Dark Orchid":
                return "05";
            case "Coral":
                return "04";
            case "Buff":
                return "01";
            case "Royal":
                return "12";
            case "Heather Grey":
                return "08";
            case "Charcoal":
                return "03";
            case "Medium Thyme":
                return "09";
            case "Warm Brown":
                return "14";
            case "Shocking Pink":
                return "13";
            case "Delft Blue":
                return "06";
            case "Gold":
                return "07";
            case "Carrott":
                return "02";
            case "Orchid":
                return "10";
            default:
                return "00";
        } //end switch
        
    } //end getScarfNum
    
    /**
     * Gets the number version of the type
     * @param type - The name of the type
     * @return the number corresponding to the type, -1 if not found
     */
    private String getTypeNum(String type){
        
        switch(type){
            
            case "Retail HB":
                return "001";
            case "Wholesale HB":
                return "002";
            case "Misc":
                return "003";
            case "In Progress Misc":
                return "004";
            case "Retail S":
                return "005";
            case "Wholesale S":
                return "006";
            case "Retail B":
                return "007";
            case "Wholesale B":
                return "008";
            case "Regular Label":
                return "009";
            case "Custom Label":
                return "010";
            default:
                return "-1";
        } //end switch
        
    } //getTypeNum
    
    /**
     * Fills the labels with information from the database
     * @param evt - When the Load Info button is clicked
     */
    @FXML
    private void refresh(ActionEvent evt){
        
        DecimalFormat df = new DecimalFormat("#.00");
        
        String emp_id = "'".concat("1".concat("'"));
        String emp_first_name = "";
        String emp_last_name = "";
        String emp_balance = "";
        String emp_email = "";
        String emp_phone = "";
        String emp_street_address1 = "";
        String emp_street_address2 = "";
        String emp_city = "";
        String emp_state = "";
        String emp_zip = "";
        
        try {
            //Opens a connection with the database
            getConnectionToDB();
            
            //Gets specific username from database
            myRs = myStatement.executeQuery("SELECT * FROM employees WHERE emp_id=" + emp_id);
            
            //Retrieves the information of the given user
            while(myRs.next()){
                emp_first_name = myRs.getString("emp_first_name");
                emp_last_name = myRs.getString("emp_last_name");
                emp_balance = myRs.getString("emp_balance");
                emp_email = myRs.getString("emp_email");
                emp_phone = myRs.getString("emp_phone");
                emp_street_address1 = myRs.getString("emp_street_address1");
                emp_street_address2 = myRs.getString("emp_street_address2");
                emp_city = myRs.getString("emp_city");
                emp_state = myRs.getString("emp_state");
                emp_zip = myRs.getString("emp_zip");
            }
            
            name.setText(emp_first_name + " " + emp_last_name);
            balanceAmount.setText("Current Balance: $" + df.format(Double.valueOf(emp_balance)));
            email.setText("Email: " + emp_email);
            phone.setText("Phone: " + emp_phone);
            street1.setText("Address: " + emp_street_address1);
            street2.setText(emp_street_address2);
            city_state_zip.setText(emp_city + " " + emp_state + " " + emp_zip);
            
        } catch (SQLException ex) {
            Logger.getLogger(LoginPage.class.getName()).log(Level.SEVERE, null, ex);
        }
        
    } //end refresh
    
    /**
     * Makes the deposit pane visible
     * @param evt - When the Deposit button is clicked
     */
    @FXML
    private void makeDeposit(ActionEvent evt){
        deposit_pane.setVisible(true);
    } //end makeDeposit
    
    /**
     * Makes the pickup pane visible
     * @param evt - When the Pickup button is clicked
     */
    @FXML
    private void makePickup(ActionEvent evt){
        pickup_pane.setVisible(true);
        
        //Fills the Type of product menu with values
        ObservableList<String> productMenu = FXCollections.observableArrayList("Headband","Scarf","Beanie","Coffee Cozy");
        product_menu.setItems(productMenu);
    } //end makePickup
    
    /**
     * Makes all of the panels invisible
     * @param evt - When cancel is clicked on any panel
     */
    @FXML
    private void cancel(ActionEvent evt){
        deposit_pane.setVisible(false);
        pickup_pane.setVisible(false);
    } //end cancel
    
    /**
     * Changes the users balance
     * @param evt - When the deposit button is clicked
     */
    @FXML
    private void deposit(ActionEvent evt){
        String amount = amountToDeposit.getText().trim();
        String confirm = confirmAmount.getText().trim();
        String emp_balance = "";
        
        
        //Amounts must be equal and above 0
        if(!amount.equals(confirm) && Double.valueOf(amount) > 0 ){
            errorLabelDeposit.setText("The amounts do not match!");
        } else {
            try {
                String emp_id = "'".concat("1".concat("'"));
                myRs = myStatement.executeQuery("SELECT * FROM employees WHERE emp_id=" + emp_id);
                
                //Gets the current balance of the user
                while(myRs.next()){
                    emp_balance = myRs.getString("emp_balance");
                }
                
                //Adds the new and old together, as doubles, but then converts back to a string
                amount = Double.toString(Double.valueOf(amount) + Double.valueOf(emp_balance));
                //Updates the database, not the label, the user is responsible for refreshing the window
                myStatement.executeUpdate("UPDATE employees SET emp_balance='" + amount + "' WHERE emp_id=" + emp_id);
                
                initialize();
                //Closes the pane and error message once the update is complete
                errorLabelDeposit.setVisible(false);
                deposit_pane.setVisible(false);
            } catch (SQLException | NumberFormatException | NullPointerException ex) {
                errorLabelDeposit.setText("There was an error, please try again");
                Logger.getLogger(LoginPage.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
        
    } //end deposit
    
    @FXML
    private void swipeAgain(ActionEvent evt){
        
        try {
            Stage primaryStage = LoginPage.primaryStage;
            FXMLLoader loader = new FXMLLoader(getClass().getResource("CardReader.fxml"));
            loader.load();
            
            Parent root = FXMLLoader.load(getClass().getResource("CardReader.fxml"));
            Scene scene = new Scene(root);
            primaryStage.setTitle("Card Reader");
            primaryStage.setScene(scene);
            primaryStage.getIcons().add(new Image(getClass().getResourceAsStream("images/jacobsloomicon.png")));
            primaryStage.show();
        } //end swipeAgain
        catch (IOException ex) {
            Logger.getLogger(EmployeeInfoController.class.getName()).log(Level.SEVERE, null, ex);
        }
        
    }
    
    /**
     * Quits the program
     * @param evt - When the close button, or close menu option is clicked
     */
    @FXML
    private void close(ActionEvent evt){
        System.exit(0);
    } //end close
    
} //end class
