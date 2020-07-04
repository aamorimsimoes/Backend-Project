<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
  header('Location: signin.php');
  exit;
} else {
  require_once('../functions.php');
  require_once('../includes/head.php');
  $section = 'news'; ?>

  <body class="app">
    <?php require_once('../includes/header.php'); ?>
    <main>
      <div class="container">
        <?php require_once('../includes/menu.php'); ?>
        <div>
          <div class="section-title">
            <h1>News</h1>
            <div>
              <a class="button" href="../crud/create.php?s=<?php echo $section; ?>">
                <svg viewBox="0 0 24 24" width="24" height="24">
                  <path fill="currentColor" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-1-11H7v2h4v4h2v-4h4v-2h-4V7h-2v4z" /></svg>Add</a>
            </div>
          </div>
          <?php
          $sql = "SELECT * FROM news WHERE status >= ? ORDER BY date DESC";
          $stmt = conn()->prepare($sql);

          if ($_SESSION['level'] >= 2) {
            $status = 0;
          } else {
            $status = 1;
          }

          if ($stmt->execute([$status])) {
            $n = $stmt->rowCount();
            if ($n > 0) {
              $data = $stmt->fetchAll();
              $stmt = null; ?>
              <table>
                <thead>
                  <tr>
                    <th class="center">#</th>
                    <th class="wide">Title</th>
                    <!-- FIXME width incorrect, fix! Author to small in comparison with total width -->
                    <th>Date</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  $i = 1;
                  foreach ($data as $r) { ?>
                    <tr>
                      <td class="center"><?php echo $i; ?></td>
                      <td><a href="../crud/create.php?s=news&token=<?php echo $r['token']; ?>"><?php echo $r['title']; ?></a></td>
                      <td class="mono"><?php echo date('d-m-Y', strtotime($r['date'])); ?></td>
                      <td class="mono"><?php echo $r['author']; ?></td>
                      <td>

                        <?php
                        $status = $r['status'];
                        if ($status === 0) {
                          echo "<div class='t$status'>Draft</div>";
                        } elseif ($status === 1) {
                          echo "<div class='t$status'>Review</div>";
                        } elseif ($status === 2) {
                          echo "<div class='t$status'>Published</div>";
                        } else {
                          echo "<div class='t$status'>Archived</div>";
                        }
                        ?>
        </div>
        </td>
        <td>
          <a href="../crud/create.php?s=<?php echo $section; ?>&token=<?php echo $r['token']; ?>">
            <svg viewBox="0 0 24 24" width="24" height="24">
              <path fill="currentColor" d="M4.929 21.485l5.846-5.846a2 2 0 1 0-1.414-1.414l-5.846 5.846-1.06-1.06c2.827-3.3 3.888-6.954 5.302-13.082l6.364-.707 5.657 5.657-.707 6.364c-6.128 1.414-9.782 2.475-13.081 5.303l-1.061-1.06zM16.596 2.04l6.347 6.346a.5.5 0 0 1-.277.848l-1.474.23-5.656-5.656.212-1.485a.5.5 0 0 1 .848-.283z" /></svg>
          </a>
        </td>
        <td>
          <a href="../crud/del.php?s=<?php echo $section; ?>&token=<?php echo $r['token']; ?>" onclick="return confirm('Are you sure you want to delete this record?')">
            <svg viewBox="0 0 24 24" width="24" height="24">
              <path fill="currentColor" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-11.414L9.172 7.757 7.757 9.172 10.586 12l-2.829 2.828 1.415 1.415L12 13.414l2.828 2.829 1.415-1.415L13.414 12l2.829-2.828-1.415-1.415L12 10.586z" /></svg>
          </a>
        </td>
        </tr>
      <?php
                    $i++;
                  } ?>
      </tbody>
      <tfoot>
        <tr>
          <td></td>
          <td colspan="6"><?php echo $n . '&nbsp;registos'; ?></td>
        </tr>
      </tfoot>
      </table>
  <?php
            } else {
              echo "Não existem registos. <a href='../crud/create.php?s=news'>Inserir</a>";
            }
          } ?>
      </div>
      </div>
    </main>
    <?php require_once('../includes/footer.php'); ?>

  </body>

  </html>


<?php
} ?>